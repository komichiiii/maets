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
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_tarjeta');
            $table->date('fecha_caducidad');
            $table->integer('codigo_seguridad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas');
    }
};
