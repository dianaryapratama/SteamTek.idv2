<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignable)
     */
    protected $fillable = [
        'name',
        'username',          // <-- Tambahan
        'email',
        'usertype',
        'phone',             // <-- Tambahan
        'password',
        'membership_type',   // <-- Tambahan (none, silver, gold)
        'surprise_discount', // <-- Tambahan
        'is_frozen',         // <-- Tambahan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_frozen' => 'boolean', // Pastikan ini dianggap boolean
        ];
    }

    /**
     * LOGIKA DISKON OTOMATIS
     * Cara panggil: $user->discount_percentage
     */
    public function getDiscountPercentageAttribute()
    {
        // 1. Cek Diskon Dasar Member
        $baseDiscount = match($this->membership_type) {
            'silver' => 7,  // Silver dapat 7%
            'gold'   => 14, // Gold dapat 14%
            default  => 0,
        };

        // 2. Tambahkan dengan Diskon Kejut dari Admin
        return $baseDiscount + $this->surprise_discount;
    }
    
}