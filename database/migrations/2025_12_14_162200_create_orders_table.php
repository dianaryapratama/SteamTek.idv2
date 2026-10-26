<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // di file create_orders_table
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_code')->unique(); // STM-2023001
        
        // Data Pembeli (Guest)
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_whatsapp'); // Untuk notif WA
        $table->text('customer_address'); // Wajib diisi sesuai request
        
        // Data Transaksi
        $table->decimal('total_price', 15, 2);
        $table->decimal('discount_amount', 15, 2)->default(0);
        $table->foreignId('payment_method_id')->constrained();
        
        // Proses Manual
        $table->string('proof_of_payment')->nullable(); // Bukti Transfer user
        $table->enum('status', ['pending', 'waiting_validation', 'completed', 'rejected', 'suspicious'])->default('pending');
        
        // Security Link (Fitur 7)
        $table->string('download_token')->nullable(); // Token unik untuk download
        $table->boolean('is_download_blocked')->default(false); // Admin bisa blokir
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
