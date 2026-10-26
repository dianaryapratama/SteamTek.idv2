<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // 1. Filter Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Filter Tipe Harga (Free / Paid)
        if ($request->has('type') && $request->type != '') {
            if ($request->type == 'free') {
                $query->where('price', 0); // Gratis
            } elseif ($request->type == 'paid') {
                $query->where('price', '>', 0); // Berbayar
            }
        }

        // Pagination
        $products = $query->latest()->paginate(12)->withQueryString(); // withQueryString agar parameter filter tidak hilang saat ganti halaman

        return view('front.catalog.index', compact('products'));
    

        // Pagination 12 produk per halaman
        $products = $query->latest()->paginate(12);

        return view('front.catalog.index', compact('products'));
    }
}
