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
        Schema::create('contenido_creador_tablas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contenido_id');
            $table->foreign('contenido_id')->references('id')->on('contenido_descargables')->onDelete('cascade');
            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenido_creador_tablas');
    }
};
