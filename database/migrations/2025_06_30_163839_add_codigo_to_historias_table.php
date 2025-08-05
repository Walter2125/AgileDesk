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
        Schema::table('historias', function (Blueprint $table) {
         if (!Schema::hasColumn('historias', 'codigo')) {
            $table->string('codigo')->nullable()->after('id');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias', function (Blueprint $table) {
            //
        });
    }
};
