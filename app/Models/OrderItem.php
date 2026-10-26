<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Kita gunakan $fillable agar lebih spesifik dan aman
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'download_token', // <--- Wajib ada agar token tersimpan
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tambahkan relasi ke Order (opsional tapi berguna)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}