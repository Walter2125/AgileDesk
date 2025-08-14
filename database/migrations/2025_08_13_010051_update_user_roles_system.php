<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Actualizar los valores predeterminados del campo usertype
            $table->string('usertype')->default('collaborator')->change();
        });
        
        // Actualizar usuarios existentes que tengan 'user' como usertype
        DB::table('users')
            ->where('usertype', 'user')
            ->update(['usertype' => 'collaborator']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir al valor anterior
            $table->string('usertype')->default('user')->change();
        });
        
        // Revertir usuarios de vuelta a 'user'
        DB::table('users')
            ->where('usertype', 'collaborator')
            ->update(['usertype' => 'user']);
    }
};
