<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Columna;
use App\Models\Tablero;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Columna>
 */
class ColumnaFactory extends Factory
{
    protected $model = Columna::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estadosColumnas = [
            'Backlog',
            'En Análisis', 
            'En Desarrollo',
            'En Pruebas',
            'Completado'
        ];

        return [
            'tablero_id' => Tablero::factory(),
            'nombre' => fake()->randomElement($estadosColumnas),
            'posicion' => fake()->numberBetween(1, 5),
        ];
    }

    /**
     * Estado específico para cada columna
     */
    public function backlog()
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'Backlog',
            'posicion' => 1,
        ]);
    }

    public function enAnalisis()
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'En Análisis',
            'posicion' => 2,
        ]);
    }

    public function enDesarrollo()
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'En Desarrollo',
            'posicion' => 3,
        ]);
    }

    public function enPruebas()
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'En Pruebas',
            'posicion' => 4,
        ]);
    }

    public function completado()
    {
        return $this->state(fn (array $attributes) => [
            'nombre' => 'Completado',
            'posicion' => 5,
        ]);
    }
}
