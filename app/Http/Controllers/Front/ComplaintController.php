<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Menampilkan halaman form kontak
    public function index()
    {
        return view('front.contact');
    }

    // Memproses pengiriman laporan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:1000',
        ]);

        Complaint::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'is_resolved' => false, // Default status: Belum Selesai
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim! Admin akan segera mengeceknya.');
    }
}