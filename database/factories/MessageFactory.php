<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Message;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recipient_id' => User::factory(),
            'inquiry_id' => Inquiry::factory(),
            'message' => fake()->paragraphs(2, true),
            'read_at' => null,
            'is_system_message' => false,
        ];
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now(),
        ]);
    }

    public function systemMessage(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_system_message' => true,
            'message' => fake()->randomElement([
                'Inquiry status changed to responded.',
                'Booking confirmed.',
                'New message received.',
            ]),
        ]);
    }

    public function withAttachments(array $attachments = null): static
    {
        return $this->state(fn (array $attributes) => [
            'attachments' => $attachments ?? [
                ['name' => 'document.pdf', 'url' => 'storage/attachments/document.pdf'],
            ],
        ]);
    }
}
