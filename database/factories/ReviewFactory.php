<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Client;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'reviewable_type' => Vendor::class,
            'reviewable_id' => Vendor::factory(),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->paragraphs(2, true),
            'pros' => fake()->sentence(),
            'cons' => fake()->sentence(),
            'is_approved' => false,
            'is_featured' => false,
            'is_verified_purchase' => false,
        ];
    }

    public function forVendor(Vendor $vendor = null): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewable_type' => Vendor::class,
            'reviewable_id' => $vendor?->id ?? Vendor::factory(),
        ]);
    }

    public function forAgency(Agency $agency = null): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewable_type' => Agency::class,
            'reviewable_id' => $agency?->id ?? Agency::factory(),
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_approved' => true,
        ]);
    }

    public function withRating(int $rating): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => min(5, max(1, $rating)),
        ]);
    }

    public function fiveStars(): static
    {
        return $this->withRating(5);
    }

    public function fourStars(): static
    {
        return $this->withRating(4);
    }

    public function verifiedPurchase(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified_purchase' => true,
        ]);
    }
}
