<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // 1. TAMPILKAN DAFTAR PRODUK
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. HALAMAN FORM TAMBAH
    public function create()
    {
        return view('admin.products.create');
    }

    // 3. PROSES SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // Ubah file_url jadi nullable agar produk gratis tidak error jika ini kosong
            'file_url' => 'nullable|url', 
            'download_link' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Handle Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. HALAMAN FORM EDIT
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_url' => 'nullable|url',      // Opsional (untuk produk berbayar)
            'download_link' => 'nullable|url', // Opsional (untuk produk gratis)
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Jika ada gambar baru, hapus yang lama & upload yang baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada di storage
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. HAPUS PRODUK
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
    }
}