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
        Schema::create('historias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('trabajo_estimado')->nullable();
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->text('descripcion')->nullable();
            $table->foreignId('columna_id')->nullable()->constrained('columnas')->onDelete('cascade');
            $table->foreignId('tablero_id')->nullable()->constrained('tableros')->onDelete('cascade');
            $table->foreignId('sprint_id')->nullable()->constrained('sprints')->onDelete('set null');
            $table->timestamps();
            $table->unique(['nombre', 'tablero_id'], 'historias_nombre_tablero_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias');
    }
};
