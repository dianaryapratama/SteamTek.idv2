<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTransaction extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi (Mass Assignment)
    protected $guarded = [];

    // Relasi: Transaksi ini milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}