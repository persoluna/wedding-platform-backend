<?php

namespace Tests\Unit\Models;

use App\Models\Inquiry;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_message_belongs_to_sender(): void
    {
        $sender = User::factory()->create();
        $message = Message::factory()->create(['user_id' => $sender->id]);

        $this->assertInstanceOf(User::class, $message->sender);
        $this->assertEquals($sender->id, $message->sender->id);
    }

    public function test_message_belongs_to_recipient(): void
    {
        $recipient = User::factory()->create();
        $message = Message::factory()->create(['recipient_id' => $recipient->id]);

        $this->assertInstanceOf(User::class, $message->recipient);
        $this->assertEquals($recipient->id, $message->recipient->id);
    }

    public function test_message_belongs_to_inquiry(): void
    {
        $inquiry = Inquiry::factory()->create();
        $message = Message::factory()->create(['inquiry_id' => $inquiry->id]);

        $this->assertInstanceOf(Inquiry::class, $message->inquiry);
        $this->assertEquals($inquiry->id, $message->inquiry->id);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Read Status
    // ─────────────────────────────────────────────────────────────────────

    public function test_message_starts_unread(): void
    {
        $message = Message::factory()->create();

        $this->assertNull($message->read_at);
        $this->assertFalse($message->isRead());
    }

    public function test_mark_as_read_sets_timestamp(): void
    {
        $message = Message::factory()->create();

        $message->markAsRead();

        $this->assertNotNull($message->read_at);
        $this->assertTrue($message->isRead());
    }

    public function test_mark_as_read_does_not_change_existing_timestamp(): void
    {
        $message = Message::factory()->read()->create();
        $originalTimestamp = $message->read_at;

        sleep(1);
        $message->markAsRead();

        $this->assertEquals($originalTimestamp->toDateTimeString(), $message->read_at->toDateTimeString());
    }

    public function test_is_read_returns_true_for_read_messages(): void
    {
        $message = Message::factory()->read()->create();

        $this->assertTrue($message->isRead());
    }

    // ─────────────────────────────────────────────────────────────────────
    // System Messages
    // ─────────────────────────────────────────────────────────────────────

    public function test_message_defaults_to_non_system(): void
    {
        $message = Message::factory()->create();

        $this->assertFalse($message->is_system_message);
    }

    public function test_system_message_factory_state(): void
    {
        $message = Message::factory()->systemMessage()->create();

        $this->assertTrue($message->is_system_message);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Attachments
    // ─────────────────────────────────────────────────────────────────────

    public function test_attachments_cast_to_json(): void
    {
        $attachments = [
            ['name' => 'proposal.pdf', 'url' => 'storage/docs/proposal.pdf'],
            ['name' => 'images.zip', 'url' => 'storage/docs/images.zip'],
        ];

        $message = Message::factory()->create(['attachments' => $attachments]);

        $fresh = $message->fresh();

        $this->assertIsArray($fresh->attachments);
        $this->assertCount(2, $fresh->attachments);
        $this->assertEquals('proposal.pdf', $fresh->attachments[0]['name']);
    }

    public function test_attachments_factory_state(): void
    {
        $message = Message::factory()->withAttachments()->create();

        $this->assertIsArray($message->attachments);
        $this->assertNotEmpty($message->attachments);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_message_can_be_soft_deleted(): void
    {
        $message = Message::factory()->create();
        $messageId = $message->id;

        $message->delete();

        $this->assertSoftDeleted('messages', ['id' => $messageId]);
    }
}
