<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show($slug)
    {
        // Ambil produk beserta review-nya, urutkan review terbaru
        $product = Product::where('slug', $slug)
                    ->where('is_active', true)
                    ->with(['reviews' => function($query) {
                        $query->latest();
                    }])
                    ->firstOrFail();

        // Hitung rata-rata rating (Opsional, biar keren)
        $avgRating = $product->reviews->avg('rating');

        return view('front.product_detail', compact('product', 'avgRating'));
    }

    public function downloadFile($token)
    {
        // Logika download aman (Nanti kita bahas detailnya)
        // Cek apakah ada order dengan token ini yang statusnya completed dan tidak diblokir
        $order = Order::where('download_token', $token)
                    ->where('status', 'completed')
                    ->where('is_download_blocked', false)
                    ->firstOrFail();
        
        // Ambil produk terkait dari item order pertama (asumsi 1 order 1 produk utama game)
        $product = $order->items->first()->product;

        // Redirect ke link asli atau download file lokal
        return redirect($product->file_url);
    }

    
}