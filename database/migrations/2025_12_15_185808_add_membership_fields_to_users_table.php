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
    Schema::table('users', function (Blueprint $table) {
        $table->string('username')->nullable()->unique()->after('name'); // Login pakai username
        $table->string('phone')->nullable()->after('email'); // No HP Opsional
        $table->enum('membership_type', ['none', 'silver', 'gold'])->default('none')->after('password');
        $table->integer('surprise_discount')->default(0)->after('membership_type'); // Diskon tambahan dari admin
        $table->boolean('is_frozen')->default(false)->after('surprise_discount'); // Fitur bekukan akun
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username', 'phone', 'membership_type', 'surprise_discount', 'is_frozen']);
    });
}
};
