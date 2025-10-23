<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [
            'name' => fake()->firstName() . ' ' . strtoupper(fake()->lastName()),
            'nombre' => ucwords(fake()->firstName()),
            'apellido' => ucwords(fake()->lastName(). ' ' . fake()->lastName()),
            'cedula' => fake()->unique()->numberBetween(1000000, 20000000),
            'email' => fake()->unique()->safeEmail(),
            'direccion' => fake()->address(),
            'telefono' => fake()->phoneNumber(),
            'fecha_nac' => fake()->dateTimeThisCentury($max = 'now', $timezone = null),
            'is_propietario' => 0,        
            'email_verified_at' => fake()->boolean(95) ? fake()->dateTimeBetween('-6 month', '-1 days', 'Europe/Brussels')->format('Y-m-d H:i:s') : null,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
 
        ];
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
