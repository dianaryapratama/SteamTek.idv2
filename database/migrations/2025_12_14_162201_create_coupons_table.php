<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // di file create_coupons_table
public function up()
{
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Kode Voucher
        $table->enum('type', ['percent', 'fixed']); // Diskon % atau Potongan Harga
        $table->decimal('value', 15, 2); // Nilai diskon
        $table->integer('max_uses')->nullable(); // Batas klaim
        $table->date('expires_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
