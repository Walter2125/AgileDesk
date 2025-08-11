<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombresEspanol = [
            'María González', 'Carlos Rodríguez', 'Ana Martínez', 'Luis Hernández',
            'Carmen López', 'Miguel Sánchez', 'Laura Jiménez', 'Roberto Díaz',
            'Sofía Morales', 'Diego Vargas', 'Patricia Ruiz', 'Alejandro Torres',
            'Isabel Castro', 'Fernando Ortiz', 'Gabriela Mendoza', 'Ricardo Vega'
        ];

        return [
            'name' => fake()->randomElement($nombresEspanol),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'usertype' => 'user',
            'is_approved' => true,
        ];
    }

    /**
     * Usuario administrador
     */
    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Administrador ' . fake()->lastName(),
            'usertype' => 'admin',
            'email' => 'admin' . fake()->numberBetween(1, 99) . '@unah.hn',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
