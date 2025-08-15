<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Historia;
use App\Models\Columna;
use App\Models\Tablero;
use App\Models\Project;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historia>
 */
class HistoriaFactory extends Factory
{
    protected $model = Historia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $historiasEjemplo = [
            'Implementar sistema de login seguro',
            'Crear dashboard administrativo',
            'Desarrollar módulo de reportes',
            'Integrar sistema de notificaciones',
            'Optimizar rendimiento de base de datos',
            'Crear interfaz de usuario moderna',
            'Implementar API REST completa',
            'Desarrollar sistema de backup',
            'Crear módulo de configuración',
            'Integrar sistema de pagos',
            'Desarrollar chat en tiempo real',
            'Implementar búsqueda avanzada',
            'Crear sistema de roles y permisos',
            'Desarrollar aplicación móvil',
            'Integrar servicios de terceros',
            'Configurar base de datos',
            'Diseñar arquitectura del sistema',
            'Implementar seguridad avanzada',
            'Crear módulo de auditoría',
            'Desarrollar sistema de logs',
            'Integrar analytics',
            'Crear dashboard ejecutivo',
            'Implementar cache distribuido',
            'Desarrollar API GraphQL',
            'Crear sistema de workflows'
        ];

        $prioridades = ['Alta', 'Media', 'Baja'];
        $timestamp = now()->timestamp;
        $random = fake()->numberBetween(1000, 9999);

        return [
            'nombre' => fake()->randomElement($historiasEjemplo) . ' - ' . $timestamp . $random,
            'trabajo_estimado' => fake()->randomElement([1, 2, 3, 5, 8, 13]), // Story points Fibonacci
            'prioridad' => fake()->randomElement($prioridades),
            'descripcion' => 'Como usuario del sistema, necesito ' . fake()->sentence() . ' para mejorar la funcionalidad y experiencia de uso.',
            'columna_id' => Columna::factory(),
            'tablero_id' => Tablero::factory(),
            'proyecto_id' => Project::factory(),
            'usuario_id' => User::factory(),
            'codigo' => 'HST-' . fake()->unique()->numberBetween(1000, 9999),
        ];
    }

    /**
     * Historia con prioridad alta
     */
    public function prioridadAlta()
    {
        return $this->state(fn (array $attributes) => [
            'prioridad' => 'Alta',
            'trabajo_estimado' => fake()->randomElement([1, 2, 3]), // Menos puntos para alta prioridad
        ]);
    }

    /**
     * Historia completada
     */
    public function completada()
    {
        return $this->state(fn (array $attributes) => [
            'prioridad' => fake()->randomElement(['Media', 'Baja']),
        ]);
    }
}
