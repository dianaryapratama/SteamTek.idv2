<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin SteamTek',
            'email' => 'admin@steamtek.com',
            'password' => Hash::make('admin123'), // Password admin
            'role' => 'admin',
        ]);
        
        // Kita isi sample metode pembayaran sekalian
        \App\Models\PaymentMethod::create([
            'name' => 'Bank BNI',
            'type' => 'bank',
            'account_number' => '1234567890',
            'account_holder' => 'Dian Arya Pratama',
            'is_active' => true
        ]);
    }
}