<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tarea;
use App\Models\Historia;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tiposTareas = [
            'Análisis de requerimientos',
            'Diseño de interfaz',
            'Implementación de lógica',
            'Desarrollo de validaciones',
            'Creación de pruebas unitarias',
            'Documentación técnica',
            'Pruebas de integración',
            'Optimización de rendimiento',
            'Configuración de base de datos',
            'Implementación de seguridad',
            'Pruebas de usuario',
            'Corrección de errores',
            'Refactorización de código',
            'Implementación de logging',
            'Validación de casos extremos'
        ];

        $actividades = [
            'Configuracion',
            'Desarrollo', 
            'Prueba',
            'Diseño',
            'OtroTipo'
        ];

        $nombreTarea = fake()->randomElement($tiposTareas);

        return [
            'nombre' => $nombreTarea,
            'descripcion' => 'Tarea específica para: ' . $nombreTarea . '. ' . fake()->sentence(),
            'historial' => 'Tarea creada el ' . fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'actividad' => fake()->randomElement($actividades),
            'user_id' => User::factory(),
            'historia_id' => Historia::factory(),
            'completada' => fake()->boolean(30), // 30% probabilidad de estar completada
        ];
    }

    /**
     * Tarea completada
     */
    public function completada()
    {
        return $this->state(fn (array $attributes) => [
            'completada' => true,
            'historial' => $attributes['historial'] . ' - Completada el ' . now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Tarea pendiente
     */
    public function pendiente()
    {
        return $this->state(fn (array $attributes) => [
            'completada' => false,
        ]);
    }
}
