<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombresProyectos = [
            'Sistema de Gestión Académica UNAH',
            'Portal Estudiantil Digital',
            'Plataforma de Matrícula Online',
            'Sistema de Biblioteca Virtual',
            'App Móvil Universitaria',
            'Sistema de Evaluación Docente',
            'Portal de Investigación',
            'Sistema de Becas y Ayudas',
            'Plataforma E-Learning',
            'Sistema de Graduación Digital'
        ];

        $descripciones = [
            'Desarrollo de un sistema integral para la gestión académica universitaria',
            'Creación de portal digital para estudiantes con funcionalidades completas',
            'Implementación de sistema moderno de matrícula en línea',
            'Desarrollo de biblioteca digital con recursos académicos',
            'Aplicación móvil para servicios universitarios',
            'Sistema para evaluación y seguimiento del desempeño docente',
            'Portal para gestión de proyectos de investigación',
            'Plataforma para administración de becas estudiantiles',
            'Sistema de aprendizaje virtual interactivo',
            'Digitalización del proceso de graduación universitaria'
        ];

        return [
            'name' => fake()->randomElement($nombresProyectos),
            'descripcion' => fake()->randomElement($descripciones),
            'codigo' => Project::generarCodigo(),
            'fecha_inicio' => fake()->dateTimeBetween('-6 months', 'now'),
            'fecha_fin' => fake()->dateTimeBetween('now', '+1 year'),
            'user_id' => User::where('usertype', 'admin')->first()->id ?? User::factory(),
        ];
    }
}
