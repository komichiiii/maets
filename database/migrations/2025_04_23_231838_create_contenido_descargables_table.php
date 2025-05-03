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
        Schema::create('contenido_descargables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('desarrolladora');
            $table->float('precio');
            $table->text('requisitos');
            $table->text('descripcion');
            $table->string('imagen', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenido_descargables');
    }
};
