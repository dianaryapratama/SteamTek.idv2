<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Opsional jika ingin melihat error di log

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Redirect jika keranjang kosong
        if(empty($cart)) {
            return redirect()->route('home');
        }

        $user = Auth::user();
        
        // Hitung Total Kasar
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // --- LOGIKA DISKON MEMBER ---
        $discountPercent = 0;
        $discountAmount = 0;

        if ($user) {
            $discountPercent = $user->discount_percentage; 
            $discountAmount = ($subtotal * $discountPercent) / 100;
        }

        $grandTotal = $subtotal - $discountAmount;

        return view('front.checkout.index', compact('cart', 'subtotal', 'discountPercent', 'discountAmount', 'grandTotal'));
    }

   public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->route('home');
        }

        // Logika User / Tamu
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        $subtotal = 0;
        foreach($cart as $item) {
            // Kita asumsikan quantity selalu 1 jika kolom quantity tidak ada di DB
            $qty = isset($item['quantity']) ? $item['quantity'] : 1;
            $subtotal += $item['price'] * $qty;
        }

        $discountAmount = 0;
        if ($user) {
            $percent = $user->discount_percentage;
            $discountAmount = ($subtotal * $percent) / 100;
        }

        $grandTotal = $subtotal - $discountAmount;
        $invoice = 'STM-' . strtoupper(Str::random(10));

        // 1. SIMPAN ORDER (Tanpa quantity/token di sini aman)
        $order = Order::create([
            'user_id' => $userId,
            'invoice_code' => $invoice,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_whatsapp' => $request->phone,
            'customer_address' => '-',
            'payment_method_id' => 1,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_price' => $grandTotal,
            // Jika gratis (Rp 0), langsung completed.
            'status' => ($grandTotal <= 0) ? 'completed' : 'pending',
        ]);
        // ==========================================
        // FITUR NOTIFIKASI ADMIN (TELEGRAM & WA)
        // ==========================================
        
        // 1. Format Pesan
        $pesanNotif = "🎉 *PESANAN BARU MASUK (SteamTek)* 🎉\n\n";
        $pesanNotif .= "🛒 *Invoice:* " . $order->invoice_code . "\n";
        $pesanNotif .= "👤 *Pembeli:* " . $order->customer_name . "\n";
        $pesanNotif .= "📱 *WA Pembeli:* " . $order->customer_whatsapp . "\n";
        $pesanNotif .= "💰 *Total Bayar:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n\n";
        $pesanNotif .= "Harap segera cek Dashboard Admin untuk memproses pesanan ini.";

        // 2. Kirim Notifikasi via WhatsApp (Fonnte)
        try {
            if (env('FONNTE_TOKEN') && env('ADMIN_WHATSAPP')) {
                Http::timeout(5)->withHeaders([
                    'Authorization' => env('FONNTE_TOKEN'), // Token API Fonnte
                ])->post('https://api.fonnte.com/send', [
                    'target' => env('ADMIN_WHATSAPP'), // Nomor WA tujuan (Admin)
                    'message' => $pesanNotif,
                    'countryCode' => '62', // Default Indonesia
                ]);
            }
        } catch (\Exception $e) {
            // Kita gunakan try-catch agar jika Fonnte error/down, 
            // Checkout pelanggan tetap berhasil dan tidak muncul halaman Error 500.
            Log::error('Fonnte Error: ' . $e->getMessage());
        }

        // 3. Kirim Notifikasi via Telegram
        try {
            if (env('TELEGRAM_BOT_TOKEN') && env('TELEGRAM_CHAT_ID')) {
                $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage";
                Http::timeout(5)->post($url, [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => $pesanNotif,
                    'parse_mode' => 'Markdown' // Agar teks yang ditebalkan (*) bisa terbaca
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Telegram Error: ' . $e->getMessage());
        }
        
        // ==========================================

        // 2. SIMPAN ITEM (PERBAIKAN UTAMA DI SINI)
        foreach($cart as $id => $details) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'price' => $details['price'],
                'download_token' => Str::random(32),
                // KITA HAPUS 'quantity' DAN 'download_token' 
                // AGAR TIDAK ERROR "COLUMN NOT FOUND"
            ]);
        }

        session()->forget('cart');

        if ($grandTotal <= 0) {
            return redirect()->route('checkout.success', $invoice);
        }

        return redirect()->route('checkout.payment', $invoice);
    }
    
    public function payment($invoice)
    {
        // Cari order berdasarkan invoice
        $order = Order::where('invoice_code', $invoice)->firstOrFail();

        // Jika status bukan pending, redirect ke sukses
        if($order->status != 'pending') {
            return redirect()->route('checkout.success', $invoice);
        }

        return view('front.payment', compact('order'));
    }

    public function uploadProof(Request $request, $invoice)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $order = Order::where('invoice_code', $invoice)->firstOrFail();

        if ($request->hasFile('proof_of_payment')) {
            $path = $request->file('proof_of_payment')->store('payment_proofs', 'public');

            $order->update([
                'proof_of_payment' => $path,
                'status' => 'waiting_validation',
            ]);
        }

        return redirect()->route('checkout.success', $invoice);
    }

    public function success($invoice)
    {
        $order = Order::where('invoice_code', $invoice)->firstOrFail();
        return view('front.success', compact('order'));
    }
}