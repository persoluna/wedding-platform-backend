<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_inquiry_belongs_to_client(): void
    {
        $inquiry = Inquiry::factory()->create();

        $this->assertInstanceOf(Client::class, $inquiry->client);
    }

    public function test_inquiry_can_belong_to_agency(): void
    {
        $agency = Agency::factory()->create();
        $inquiry = Inquiry::factory()->forAgency($agency)->create();

        $this->assertInstanceOf(Agency::class, $inquiry->agency);
        $this->assertEquals($agency->id, $inquiry->agency->id);
    }

    public function test_inquiry_can_belong_to_vendor(): void
    {
        $vendor = Vendor::factory()->create();
        $inquiry = Inquiry::factory()->forVendor($vendor)->create();

        $this->assertInstanceOf(Vendor::class, $inquiry->vendor);
        $this->assertEquals($vendor->id, $inquiry->vendor->id);
    }

    public function test_inquiry_has_many_messages(): void
    {
        $inquiry = Inquiry::factory()->create();
        Message::factory()->count(3)->create(['inquiry_id' => $inquiry->id]);

        $this->assertCount(3, $inquiry->messages);
    }

    public function test_inquiry_can_have_booking(): void
    {
        $inquiry = Inquiry::factory()->create();
        $booking = Booking::factory()->create(['inquiry_id' => $inquiry->id]);

        $this->assertInstanceOf(Booking::class, $inquiry->booking);
        $this->assertEquals($booking->id, $inquiry->booking->id);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Status Transitions
    // ─────────────────────────────────────────────────────────────────────

    public function test_mark_as_responded_updates_status_and_timestamp(): void
    {
        Carbon::setTestNow('2025-06-15 10:00:00');

        $inquiry = Inquiry::factory()->statusNew()->create();

        $inquiry->markAsResponded();

        $this->assertEquals('responded', $inquiry->status);
        $this->assertEquals('2025-06-15 10:00:00', $inquiry->responded_at->toDateTimeString());

        Carbon::setTestNow();
    }

    public function test_record_follow_up_updates_timestamp(): void
    {
        Carbon::setTestNow('2025-06-20 14:30:00');

        $inquiry = Inquiry::factory()->responded()->create();

        $inquiry->recordFollowUp();

        $this->assertEquals('2025-06-20 14:30:00', $inquiry->last_follow_up_at->toDateTimeString());

        Carbon::setTestNow();
    }

    public function test_close_with_booked_status(): void
    {
        Carbon::setTestNow('2025-06-25 09:00:00');

        $inquiry = Inquiry::factory()->inProgress()->create();

        $inquiry->close('booked');

        $this->assertEquals('booked', $inquiry->status);
        $this->assertEquals('2025-06-25 09:00:00', $inquiry->closed_at->toDateTimeString());

        Carbon::setTestNow();
    }

    public function test_close_with_cancelled_status(): void
    {
        $inquiry = Inquiry::factory()->inProgress()->create();

        $inquiry->close('cancelled');

        $this->assertEquals('cancelled', $inquiry->status);
        $this->assertNotNull($inquiry->closed_at);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Status Checks
    // ─────────────────────────────────────────────────────────────────────

    public function test_is_new_returns_true_for_new_status(): void
    {
        $inquiry = Inquiry::factory()->statusNew()->create();

        $this->assertTrue($inquiry->isNew());
        $this->assertFalse($inquiry->isResponded());
        $this->assertFalse($inquiry->isBooked());
    }

    public function test_is_responded_returns_true_for_responded_status(): void
    {
        $inquiry = Inquiry::factory()->responded()->create();

        $this->assertTrue($inquiry->isResponded());
        $this->assertFalse($inquiry->isNew());
    }

    public function test_is_booked_returns_true_for_booked_status(): void
    {
        $inquiry = Inquiry::factory()->booked()->create();

        $this->assertTrue($inquiry->isBooked());
        $this->assertTrue($inquiry->isClosed());
    }

    public function test_is_closed_returns_true_for_closed_statuses(): void
    {
        $booked = Inquiry::factory()->booked()->create();
        $cancelled = Inquiry::factory()->cancelled()->create();

        $this->assertTrue($booked->isClosed());
        $this->assertTrue($cancelled->isClosed());
    }

    public function test_is_closed_returns_false_for_open_statuses(): void
    {
        $new = Inquiry::factory()->statusNew()->create();
        $responded = Inquiry::factory()->responded()->create();

        $this->assertFalse($new->isClosed());
        $this->assertFalse($responded->isClosed());
    }

    // ─────────────────────────────────────────────────────────────────────
    // Computed Attributes
    // ─────────────────────────────────────────────────────────────────────

    public function test_days_since_creation_calculated_correctly(): void
    {
        Carbon::setTestNow('2025-06-20 12:00:00');

        $inquiry = Inquiry::factory()->create([
            'created_at' => Carbon::parse('2025-06-15 12:00:00'),
        ]);

        $this->assertEquals(5, $inquiry->days_since_creation);

        Carbon::setTestNow();
    }

    // ─────────────────────────────────────────────────────────────────────
    // Urgency
    // ─────────────────────────────────────────────────────────────────────

    public function test_inquiry_can_be_marked_urgent(): void
    {
        $inquiry = Inquiry::factory()->urgent()->create();

        $this->assertTrue($inquiry->is_urgent);
    }

    public function test_inquiry_defaults_to_not_urgent(): void
    {
        $inquiry = Inquiry::factory()->create();

        $this->assertFalse($inquiry->is_urgent);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Source Tracking
    // ─────────────────────────────────────────────────────────────────────

    public function test_inquiry_tracks_source(): void
    {
        $inquiry = Inquiry::factory()->create(['source' => 'referral']);

        $this->assertEquals('referral', $inquiry->source);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_inquiry_can_be_soft_deleted(): void
    {
        $inquiry = Inquiry::factory()->create();
        $inquiryId = $inquiry->id;

        $inquiry->delete();

        $this->assertSoftDeleted('inquiries', ['id' => $inquiryId]);
    }
}
