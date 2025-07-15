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
        Schema::table('tareas', function (Blueprint $table) {
        if (!Schema::hasColumn('tareas', 'proyecto_id')) {
    $table->unsignedBigInteger('proyecto_id')->nullable();
}


        if (!Schema::hasColumn('tareas', 'proyecto_id')) {
    $table->foreign('proyecto_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade');
}

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            //
        });
    }
};
