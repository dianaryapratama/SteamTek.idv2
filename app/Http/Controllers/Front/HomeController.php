<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(Request $request)
{
    // 1. Ambil Banner
    $banners = \App\Models\Banner::where('is_active', true)->latest()->get();

    // 2. Ambil Semua Produk (Untuk List Bawah & Pencarian)
    $query = \App\Models\Product::query();
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    $products = Product::where('is_active', true)
                           ->latest()
                           ->take(10) // Batasi 10 produk
                           ->get();

    // 3. Ambil Produk Terlaris (Real Database)
        // Syarat: Berbayar (>0) DAN Diurutkan berdasarkan jumlah order terbanyak
        $bestSellers = \App\Models\Product::where('price', '>', 0)
                        ->withCount('orderItems') // Hitung jumlah transaksi per produk
                        ->orderBy('order_items_count', 'desc') // Urutkan dari terbanyak
                        ->take(4)
                        ->get();

    return view('front.home', compact('products', 'banners', 'bestSellers'));
}
}