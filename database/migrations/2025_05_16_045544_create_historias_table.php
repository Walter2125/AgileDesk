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
            $table->integer('numero');
            $table->string('nombre');
            $table->integer('trabajo_estimado')->nullable();
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->text('descripcion')->nullable();
            $table->foreignId('columna_id')->nullable()->constrained('columnas')->onDelete('cascade');
            $table->foreignId('tablero_id')->nullable()->constrained('tableros')->onDelete('cascade');
            $table->foreignId('sprint_id')->nullable()->constrained('sprints')->onDelete('set null');
            $table->timestamps();
            $table->unique(['proyecto_id', 'numero']); 
            $table->unique(['nombre', 'tablero_id'], 'historias_nombre_tablero_unique');
            $table->unique(['nombre', 'proyecto_id'], 'historias_nombre_proyecto_unique');
            $table->foreignId('proyecto_id')->constrained('nuevo_proyecto')->onDelete('cascade');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('historias', function (Blueprint $table) {
        $table->dropForeign(['usuario_id']);
        $table->dropColumn('usuario_id');
    });
}
};
