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
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'type' => 'client',
            'phone' => fake()->phoneNumber(),
            'active' => true,
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

    /**
     * Configure as admin user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'admin',
        ]);
    }

    /**
     * Configure as agency user.
     */
    public function agency(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'agency',
        ]);
    }

    /**
     * Configure as vendor user.
     */
    public function vendor(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'vendor',
        ]);
    }

    /**
     * Configure as client user.
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'client',
        ]);
    }

    /**
     * Configure as inactive user.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}
