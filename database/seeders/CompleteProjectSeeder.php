<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Tablero;
use App\Models\Columna;
use App\Models\Historia;
use App\Models\Tarea;

class CompleteProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Admin',
        'email' => 'admin@unah.hn',
        'password' => 'Rsbarm25',
        'usertype' => 'superadmin',
        'is_approved' => true,
    ]);
        // Verificar si ya existen datos
        if (Project::count() > 0) {
            $this->command->warn('⚠️  Ya existen proyectos. Saltando seeding para evitar duplicados.');
            $this->command->info('💡 Usa: php artisan migrate:fresh --seed para reiniciar la BD');
            return;
        }

        // 1. Crear 10 usuarios regulares
        $usuarios = User::factory()->count(10)->create();

        // 2. Buscar admin, si no existe usar superadmin
        $admin = User::where('usertype', 'admin')->first();
        if (!$admin) {
            $admin = User::where('usertype', 'superadmin')->first();
        }

        $proyecto = Project::factory()->create([
            'name' => 'Sistema de Gestión Académica UNAH - ' . now()->format('Y-m-d'),
            'descripcion' => 'Desarrollo integral del sistema académico universitario con módulos de matrícula, calificaciones, horarios y reportes.',
            'user_id' => $admin ? $admin->id : null
        ]);

        // Asignar todos los usuarios al proyecto
        $proyecto->users()->attach($usuarios->pluck('id'));
       
        // 3. Crear tablero para el proyecto
        $tablero = Tablero::factory()->create([
            'proyecto_id' => $proyecto->id
        ]);
        // 4. Crear 5 columnas con estados específicos 
        $estadosColumnas = [
            ['nombre' => 'Backlog', 'posicion' => 1],
            ['nombre' => 'En Análisis', 'posicion' => 2],
            ['nombre' => 'En Desarrollo', 'posicion' => 3],
            ['nombre' => 'En Pruebas', 'posicion' => 4],
            ['nombre' => 'Completado', 'posicion' => 5],
        ];

        $columnas = collect();
        foreach ($estadosColumnas as $estadoData) {
            $columna = Columna::factory()->create([
                'tablero_id' => $tablero->id,
                'nombre' => $estadoData['nombre'],
                'posicion' => $estadoData['posicion']
            ]);
            $columnas->push($columna);
           
        }

        // 5. Crear 15 historias por columna (75 total)
        $historiasCreadas = 0;
        foreach ($columnas as $columna) {
            $historias = Historia::factory()->count(15)->create([
                'columna_id' => $columna->id,
                'tablero_id' => $tablero->id,
                'proyecto_id' => $proyecto->id,
                'usuario_id' => $usuarios->random()->id
            ]);
            
            $historiasCreadas += $historias->count();
            // 6. Crear 5 tareas por cada historia (375 total)
            foreach ($historias as $historia) {
                Tarea::factory()->count(5)->create([
                    'historia_id' => $historia->id,
                    'user_id' => $usuarios->random()->id
                ]);
            }
        }

        $totalTareas = $historiasCreadas * 5;
        
        // Resumen final
         $this->command->table(
            ['Elemento', 'Cantidad'],
            [
                ['Usuarios', User::count()],
                ['Proyectos', Project::count()],
                ['Tableros', Tablero::count()],
                ['Columnas', Columna::count()],
                ['Historias', Historia::count()],
                ['Tareas', Tarea::count()],
            ]
        );

    }
}
