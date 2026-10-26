<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'invoice_code' => 'required|exists:orders,invoice_code',
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:50',
            'comment' => 'required|string|max:500',
        ]);

        // 1. Cek Validasi: Apakah Invoice tersebut BENAR-BENAR membeli produk ini?
        $order = Order::where('invoice_code', $request->invoice_code)
                      ->where('status', 'completed') // Harus sudah lunas
                      ->whereHas('items', function($query) use ($productId) {
                          $query->where('product_id', $productId);
                      })
                      ->first();

        if (!$order) {
            return back()->with('error', 'Invoice tidak valid, belum lunas, atau tidak mengandung produk ini.');
        }

        // 2. Cek apakah invoice ini sudah pernah mereview produk ini? (Biar ga spam)
        $existingReview = Review::where('order_id', $order->id)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk produk ini sebelumnya.');
        }

        // 3. Simpan Review
        Review::create([
            'product_id' => $productId,
            'order_id' => $order->id,
            'reviewer_name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasanmu berhasil ditambahkan.');
    }
}