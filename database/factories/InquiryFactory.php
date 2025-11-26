<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'agency_id' => null,
            'vendor_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'event_date' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'event_location' => fake()->city() . ', ' . fake()->state(),
            'guest_count' => fake()->numberBetween(50, 500),
            'message' => fake()->paragraphs(2, true),
            'budget' => fake()->numberBetween(100000, 2000000),
            'status' => 'new',
            'is_urgent' => false,
            'source' => fake()->randomElement(['website', 'referral', 'social', 'google']),
        ];
    }

    public function forAgency(Agency $agency = null): static
    {
        return $this->state(fn (array $attributes) => [
            'agency_id' => $agency?->id ?? Agency::factory(),
        ]);
    }

    public function forVendor(Vendor $vendor = null): static
    {
        return $this->state(fn (array $attributes) => [
            'vendor_id' => $vendor?->id ?? Vendor::factory(),
        ]);
    }

    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_urgent' => true,
        ]);
    }

    public function statusNew(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
            'responded_at' => null,
            'closed_at' => null,
        ]);
    }

    public function responded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'responded',
            'responded_at' => now(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'responded_at' => now()->subDays(2),
            'last_follow_up_at' => now(),
        ]);
    }

    public function booked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'booked',
            'responded_at' => now()->subWeek(),
            'closed_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'responded_at' => now()->subWeek(),
            'closed_at' => now(),
        ]);
    }
}
