<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    // 1. Tampilkan Halaman Pilih Paket
    public function index()
    {
        // Cek apakah user sudah punya transaksi pending?
        $pendingTx = MembershipTransaction::where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->first();

        return view('front.membership.index', compact('pendingTx'));
    }

    // 2. Tampilkan Halaman Bayar & Upload Bukti
    public function payment(Request $request)
    {
        $type = $request->query('type');
        
        // Validasi input manual di URL
        if (!in_array($type, ['silver', 'gold'])) {
            return redirect()->route('membership.index');
        }

        $price = ($type == 'silver') ? 10000 : 20000;

        return view('front.membership.payment', compact('type', 'price'));
    }

    // 3. Proses Simpan Transaksi
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:silver,gold',
            'proof_image' => 'required|image|max:2048', // Max 2MB
        ]);

        $price = ($request->type == 'silver') ? 10000 : 20000;

        // Upload Gambar
        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        MembershipTransaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $price,
            'proof_image' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('membership.index')->with('success', 'Bukti terkirim! Tunggu validasi admin.');
    }
}