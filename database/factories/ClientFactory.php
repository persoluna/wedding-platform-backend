<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->client(),
            'partner_name' => fake()->name(),
            'wedding_date' => fake()->dateTimeBetween('+1 month', '+2 years'),
            'wedding_city' => fake()->city(),
            'wedding_state' => fake()->state(),
            'wedding_venue' => fake()->company() . ' ' . fake()->randomElement(['Resort', 'Palace', 'Gardens', 'Banquet']),
            'guest_count' => fake()->numberBetween(50, 1000),
            'budget' => fake()->numberBetween(500000, 10000000),
            'wedding_type' => fake()->randomElement(['traditional', 'destination', 'themed', 'intimate', 'other']),
            'planning_status' => 'planning',
        ];
    }

    public function justEngaged(): static
    {
        return $this->state(fn (array $attributes) => [
            'planning_status' => 'just_engaged',
            'wedding_date' => null,
            'wedding_venue' => null,
        ]);
    }

    public function planning(): static
    {
        return $this->state(fn (array $attributes) => [
            'planning_status' => 'planning',
        ]);
    }

    public function finalizing(): static
    {
        return $this->state(fn (array $attributes) => [
            'planning_status' => 'finalizing',
            'wedding_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'planning_status' => 'completed',
            'wedding_date' => fake()->dateTimeBetween('-1 year', '-1 week'),
        ]);
    }

    public function withBudget(float $budget): static
    {
        return $this->state(fn (array $attributes) => [
            'budget' => $budget,
        ]);
    }

    public function destinationWedding(): static
    {
        return $this->state(fn (array $attributes) => [
            'wedding_type' => 'destination',
            'wedding_city' => fake()->randomElement(['Udaipur', 'Jaipur', 'Goa', 'Kerala']),
        ]);
    }
}
