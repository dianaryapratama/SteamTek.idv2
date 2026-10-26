<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Ambil semua user (kecuali admin) agar user baru (none) juga muncul
        $members = User::where('usertype', '!=', 'admin')
                    ->latest()
                    ->paginate(10);

        // Ambil Request Upgrade yang MASIH PENDING
        $pendingTransactions = MembershipTransaction::with('user')
                                ->where('status', 'pending')
                                ->latest()
                                ->get();

        return view('admin.members.index', compact('members', 'pendingTransactions'));
    }

    // Update Data Member (Diskon Kejut, Bekukan Akun, atau Manual Upgrade Level)
    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);
        
        $request->validate([
            'membership_type' => 'required|in:none,silver,gold', // <-- Tambahkan Validasi Ini
            'surprise_discount' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,frozen'
        ]);

        $member->update([
            'membership_type' => $request->membership_type, // <-- Tambahkan Update Ini
            'surprise_discount' => $request->surprise_discount ?? 0,
            'is_frozen' => $request->status == 'frozen' ? true : false,
        ]);

        return back()->with('success', 'Data member berhasil diperbarui.');
    }

    public function approveTransaction($id)
    {
        $transaction = MembershipTransaction::findOrFail($id);
        
        $transaction->update(['status' => 'approved']);

        $user = $transaction->user;
        $user->update([
            'membership_type' => $transaction->type,
            'surprise_discount' => 0 
        ]);

        return back()->with('success', 'Transaksi disetujui! User sekarang member ' . ucfirst($transaction->type));
    }

    public function rejectTransaction($id)
    {
        $transaction = MembershipTransaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);

        return back()->with('error', 'Transaksi ditolak.');
    }
}