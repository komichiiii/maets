<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paypal')->nullable();
            $table->foreign('paypal')->references('id')->on('paypals');
            $table->unsignedBigInteger('tarjeta')->nullable();
            $table->foreign('tarjeta')->references('id')->on('tarjetas');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('datos_factura_id');
            $table->foreign('datos_factura_id')->references('id')->on('datos_facturas');
            $table->string('numero_factura')->unique();
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
