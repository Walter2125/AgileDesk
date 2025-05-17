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
        Schema::create('columnas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tablero_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->boolean('es_backlog')->default(false); // Marca si es la columna Backlog
            $table->unsignedInteger('posicion')->default(0); // Orden de visualización
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columnas');
    }
};
