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
    Schema::create('comentarios', function (Blueprint $table) { 
        $table->id(); 
        $table->unsignedBigInteger('historia_id'); 
        $table->unsignedBigInteger('user_id'); 
        $table->unsignedBigInteger('parent_id')->nullable(); // Para respuestas 
        $table->text('contenido'); 
        $table->timestamps(); 
        $table->softDeletes(); // Agregar soft deletes
 
        $table->foreign('historia_id')->references('id')->on('historias')->onDelete('cascade'); 
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
        $table->foreign('parent_id')->references('id')->on('comentarios')->onDelete('cascade'); 
    }); 
} 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
