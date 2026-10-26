<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'GTA V: Realistic Graphics Mod',
            'slug' => 'gta-v-realistic-mod',
            'description' => 'Mod grafik ultra realistis untuk GTA V. Mengubah pencahayaan, tekstur jalanan, dan refleksi air menjadi seperti dunia nyata. Spesifikasi PC High-End direkomendasikan.',
            'price' => 50000,
            'image' => 'https://images.unsplash.com/photo-1605901309584-818e25960b8f?q=80&w=1000&auto=format&fit=crop',
            'file_url' => 'https://google.com', // Link dummy
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Minecraft: Shader Pack Ultimate',
            'slug' => 'minecraft-shader-pack',
            'description' => 'Shader pack ringan namun indah untuk Minecraft Java Edition. Menambahkan efek bayangan dinamis, air jernih, dan dedaunan bergoyang.',
            'price' => 25000,
            'image' => 'https://images.unsplash.com/photo-1607853202273-797f1c22a38e?q=80&w=1000&auto=format&fit=crop',
            'file_url' => 'https://google.com',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Elden Ring: Easy Mode Mod',
            'slug' => 'elden-ring-easy-mode',
            'description' => 'Kesulitan main Elden Ring? Mod ini menaikkan damage player 50% dan mengurangi damage musuh. Cocok untuk menikmati cerita tanpa stres.',
            'price' => 30000,
            'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=1000&auto=format&fit=crop',
            'file_url' => 'https://google.com',
            'is_active' => true,
        ]);
    }
}