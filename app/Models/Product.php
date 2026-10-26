<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id']; // Mengizinkan semua kolom diisi kecuali ID
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'image',
        'file_url',      // Link untuk produk berbayar
        'download_link', // <-- TAMBAHKAN INI
    ];
    // Relasi (Nanti berguna untuk keranjang)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
