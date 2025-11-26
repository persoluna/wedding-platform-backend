<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $amount = fake()->numberBetween(50000, 500000);
        $depositAmount = $amount * 0.3;

        return [
            'client_id' => Client::factory(),
            'bookable_type' => Vendor::class,
            'bookable_id' => Vendor::factory(),
            'inquiry_id' => null,
            'event_date' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'event_location' => fake()->city() . ', ' . fake()->state(),
            'start_time' => '10:00',
            'end_time' => '22:00',
            'amount' => $amount,
            'deposit_amount' => $depositAmount,
            'balance_amount' => $amount - $depositAmount,
            'status' => 'pending',
            'notes' => fake()->sentence(),
        ];
    }

    public function forVendor(Vendor $vendor = null): static
    {
        return $this->state(fn (array $attributes) => [
            'bookable_type' => Vendor::class,
            'bookable_id' => $vendor?->id ?? Vendor::factory(),
        ]);
    }

    public function forAgency(Agency $agency = null): static
    {
        return $this->state(fn (array $attributes) => [
            'bookable_type' => Agency::class,
            'bookable_id' => $agency?->id ?? Agency::factory(),
        ]);
    }

    public function fromInquiry(Inquiry $inquiry = null): static
    {
        return $this->state(fn (array $attributes) => [
            'inquiry_id' => $inquiry?->id ?? Inquiry::factory(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'deposit_paid_at' => null,
            'full_payment_received_at' => null,
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'deposit_paid_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'deposit_paid_at' => now()->subMonth(),
            'full_payment_received_at' => now(),
            'event_date' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    public function fullyPaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'deposit_paid_at' => now()->subMonth(),
            'full_payment_received_at' => now(),
            'balance_amount' => 0,
        ]);
    }

    public function withAmount(float $amount, float $depositPercent = 0.3): static
    {
        $depositAmount = $amount * $depositPercent;

        return $this->state(fn (array $attributes) => [
            'amount' => $amount,
            'deposit_amount' => $depositAmount,
            'balance_amount' => $amount - $depositAmount,
        ]);
    }
}
