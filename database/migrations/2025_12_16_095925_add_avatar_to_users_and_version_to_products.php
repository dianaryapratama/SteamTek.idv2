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
        $table->string('avatar')->nullable()->after('email');
    });

    Schema::table('products', function (Blueprint $table) {
        $table->string('version')->default('1.0')->after('name'); // Cth: v1.2
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('avatar');
    });
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('version');
    });
}
};
