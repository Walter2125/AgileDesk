<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Comentamos el seeder que crea usuarios admin automáticamente
        // El primer usuario registrado se convertirá automáticamente en superadmin
        
        // $this->call([
        //     CompleteProjectSeeder::class,
        // ]);
        
        $this->command->info('🎉 Base de datos preparada para el nuevo sistema de roles');
        $this->command->info('📋 El primer usuario que se registre será automáticamente superadministrador');
        $this->command->warn('⚠️ Asegúrate de registrar el primer usuario con cuidado');
    }
}
