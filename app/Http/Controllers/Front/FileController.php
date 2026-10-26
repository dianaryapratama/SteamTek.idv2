<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Menerima parameter TOKEN, bukan ID
    public function download($token)
    {
        // 1. Cari Item berdasarkan Token
        $item = OrderItem::with(['product', 'order'])->where('download_token', $token)->firstOrFail();

        // 2. Logika Validasi Download
        // Boleh download JIKA: (Harga 0) ATAU (Status Order 'completed')
        $isFree = $item->price <= 0;
        $isPaid = $item->order->status == 'completed';

        if (!$isFree && !$isPaid) {
            abort(403, 'Pesanan belum lunas. Silakan selesaikan pembayaran.');
        }

        // 3. Ambil File
        $filePath = $item->product->download_url; // Pastikan kolom ini benar di tabel products

        if (!$filePath) {
            abort(404, 'File belum diupload oleh admin.');
        }

        // 4. Download
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return redirect()->away($filePath);
        }

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        abort(404, 'File fisik tidak ditemukan.');
    }
}