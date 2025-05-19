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
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_sprint')->default(1);

            $table->string('nombre');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('proyecto_id')->constrained('nuevo_proyecto')->onDelete('cascade');
            $table->foreignId('tablero_id')->constrained('tableros')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprints');
    }
};
