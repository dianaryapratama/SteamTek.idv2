<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // di file create_payment_methods_table
public function up()
{
    Schema::create('payment_methods', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Misal: BCA, OVO, QRIS
        $table->string('type'); // bank, ewallet, qris
        $table->string('account_number')->nullable(); // No Rek
        $table->string('account_holder')->nullable(); // Atas Nama
        $table->string('qris_image')->nullable(); // Jika QRIS
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
