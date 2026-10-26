<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Mengubah kolom file_url agar BOLEH KOSONG (nullable)
            $table->string('file_url')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Kembalikan jadi wajib isi jika dibatalkan
            $table->string('file_url')->nullable(false)->change();
        });
    }
};
