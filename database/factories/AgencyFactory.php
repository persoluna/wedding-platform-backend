<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Agency>
 */
class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        $name = fake()->company() . ' Wedding Agency';

        return [
            'user_id' => User::factory()->agency(),
            'business_name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(5),
            'description' => fake()->paragraphs(3, true),
            'website' => fake()->url(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => 'India',
            'latitude' => fake()->latitude(8, 37),
            'longitude' => fake()->longitude(68, 97),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'whatsapp' => fake()->phoneNumber(),
            'avg_rating' => 0,
            'review_count' => 0,
            'years_in_business' => fake()->numberBetween(1, 25),
            'verified' => false,
            'featured' => false,
            'premium' => false,
            'views_count' => 0,
            'subscription_status' => 'free',
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified' => true,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'premium' => true,
            'subscription_status' => 'premium',
            'subscription_expires_at' => now()->addYear(),
        ]);
    }

    public function withRating(float $rating, int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'avg_rating' => $rating,
            'review_count' => $count,
        ]);
    }
}
