<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // 1. Hitung Subtotal
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // 2. Hitung Diskon Member (Jika User Login & Punya Member)
        $memberDiscountAmount = 0;
        if (Auth::check() && Auth::user()->membership_type != 'none') {
            // Asumsi di tabel users ada kolom 'discount_percentage'
            // Jika tidak ada, ganti manual misal: $persen = 10;
            $persen = Auth::user()->discount_percentage ?? 0; 
            $memberDiscountAmount = ($subtotal * $persen) / 100;
        }

        // 3. Hitung Diskon Kupon (Jika ada kode di session)
        $couponDiscountAmount = 0;
        $couponCode = session()->get('coupon_code'); 
        
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            
            // Cek apakah kupon valid & belum expired
            if ($coupon && (!$coupon->expires_at || now()->lt($coupon->expires_at))) {
                if ($coupon->type == 'percent') {
                    // Diskon persen dihitung dari (Subtotal - Diskon Member) agar tidak rugi double
                    // Atau dari Subtotal murni (tergantung kebijakan toko Anda)
                    // Di sini saya hitung dari Subtotal murni:
                    $couponDiscountAmount = ($subtotal * $coupon->value) / 100;
                } else {
                    $couponDiscountAmount = $coupon->value;
                }
            } else {
                // Jika kupon tidak valid/expired, hapus dari session
                session()->forget('coupon_code');
            }
        }

        // Validasi: Jangan sampai diskon lebih besar dari total belanja
        $totalDiscount = $memberDiscountAmount + $couponDiscountAmount;
        if($totalDiscount > $subtotal) {
            $couponDiscountAmount = $subtotal - $memberDiscountAmount; // Mentok di 0
        }

        // PENTING: Simpan nominal diskon ke session agar View & Checkout bisa baca
        session()->put('coupon_amount', $couponDiscountAmount);

        // 4. Hitung Total Akhir
        $grandTotal = max($subtotal - $memberDiscountAmount - $couponDiscountAmount, 0);

        // Kirim semua variabel ke View
        return view('front.cart', compact(
            'cart', 
            'subtotal', 
            'memberDiscountAmount', // Untuk ditampilkan sebagai "Diskon Member"
            'couponDiscountAmount', // Untuk ditampilkan sebagai "Voucher"
            'grandTotal'            // Total Akhir
        ))->with('discountAmount', $memberDiscountAmount); // Alias agar cocok dengan view sebelumnya
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            return redirect()->route('cart.index')->with('info', 'Produk ini sudah ada di keranjang Anda.');
        }

        $cart[$id] = [
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            'image' => Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus.');
    }

    // --- LOGIKA KUPON ---
    
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required']);
        $code = strtoupper($request->code);

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Kode voucher tidak ditemukan!');
        }
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return redirect()->back()->with('error', 'Voucher ini sudah kadaluarsa!');
        }

        // Simpan KODE saja, perhitungan nominal dilakukan di function index()
        // agar kalau cart berubah, diskon ikut terupdate otomatis
        session()->put('coupon_code', $coupon->code);

        return redirect()->back()->with('success', 'Voucher berhasil dipasang!');
    }

    public function removeCoupon()
    {
        session()->forget(['coupon_code', 'coupon_amount']);
        return redirect()->back()->with('success', 'Voucher dilepas.');
    }
}