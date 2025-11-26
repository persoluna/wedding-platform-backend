<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_booking_belongs_to_client(): void
    {
        $booking = Booking::factory()->create();

        $this->assertInstanceOf(Client::class, $booking->client);
    }

    public function test_booking_can_be_for_vendor(): void
    {
        $vendor = Vendor::factory()->create();
        $booking = Booking::factory()->forVendor($vendor)->create();

        $this->assertInstanceOf(Vendor::class, $booking->bookable);
        $this->assertEquals($vendor->id, $booking->bookable->id);
    }

    public function test_booking_can_be_for_agency(): void
    {
        $agency = Agency::factory()->create();
        $booking = Booking::factory()->forAgency($agency)->create();

        $this->assertInstanceOf(Agency::class, $booking->bookable);
        $this->assertEquals($agency->id, $booking->bookable->id);
    }

    public function test_booking_can_have_inquiry(): void
    {
        $inquiry = Inquiry::factory()->create();
        $booking = Booking::factory()->fromInquiry($inquiry)->create();

        $this->assertInstanceOf(Inquiry::class, $booking->inquiry);
        $this->assertEquals($inquiry->id, $booking->inquiry->id);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Status Transitions
    // ─────────────────────────────────────────────────────────────────────

    public function test_confirm_sets_status_to_confirmed(): void
    {
        $booking = Booking::factory()->pending()->create();

        $booking->confirm();

        $this->assertEquals('confirmed', $booking->status);
    }

    public function test_cancel_sets_status_to_cancelled(): void
    {
        $booking = Booking::factory()->confirmed()->create();

        $booking->cancel();

        $this->assertEquals('cancelled', $booking->status);
    }

    public function test_complete_sets_status_to_completed(): void
    {
        $booking = Booking::factory()->confirmed()->create();

        $booking->complete();

        $this->assertEquals('completed', $booking->status);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Payment Tracking
    // ─────────────────────────────────────────────────────────────────────

    public function test_is_deposit_paid_returns_true_when_paid(): void
    {
        $booking = Booking::factory()->confirmed()->create();

        $this->assertTrue($booking->isDepositPaid());
    }

    public function test_is_deposit_paid_returns_false_when_not_paid(): void
    {
        $booking = Booking::factory()->pending()->create();

        $this->assertFalse($booking->isDepositPaid());
    }

    public function test_is_fully_paid_returns_true_when_fully_paid(): void
    {
        $booking = Booking::factory()->fullyPaid()->create();

        $this->assertTrue($booking->isFullyPaid());
    }

    public function test_is_fully_paid_returns_false_when_not_paid(): void
    {
        $booking = Booking::factory()->confirmed()->create();

        $this->assertFalse($booking->isFullyPaid());
    }

    // ─────────────────────────────────────────────────────────────────────
    // Amount Formatting
    // ─────────────────────────────────────────────────────────────────────

    public function test_formatted_amount_includes_currency_symbol(): void
    {
        $booking = Booking::factory()->withAmount(150000)->create();

        $this->assertEquals('₹150,000.00', $booking->formatted_amount);
    }

    public function test_formatted_deposit_amount(): void
    {
        $booking = Booking::factory()->withAmount(100000, 0.3)->create();

        $this->assertEquals('₹30,000.00', $booking->formatted_deposit_amount);
    }

    public function test_formatted_balance_amount(): void
    {
        $booking = Booking::factory()->withAmount(100000, 0.3)->create();

        $this->assertEquals('₹70,000.00', $booking->formatted_balance_amount);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────────────────────────────

    public function test_confirmed_scope_filters_confirmed_bookings(): void
    {
        Booking::factory()->pending()->create();
        Booking::factory()->confirmed()->create();
        Booking::factory()->confirmed()->create();
        Booking::factory()->cancelled()->create();

        $this->assertCount(2, Booking::confirmed()->get());
    }

    public function test_pending_scope_filters_pending_bookings(): void
    {
        Booking::factory()->pending()->create();
        Booking::factory()->pending()->create();
        Booking::factory()->confirmed()->create();

        $this->assertCount(2, Booking::pending()->get());
    }

    public function test_upcoming_scope_filters_future_events(): void
    {
        Booking::factory()->create(['event_date' => Carbon::now()->addWeek()]);
        Booking::factory()->create(['event_date' => Carbon::now()->addMonth()]);
        Booking::factory()->create(['event_date' => Carbon::now()->subWeek()]);

        $this->assertCount(2, Booking::upcoming()->get());
    }

    // ─────────────────────────────────────────────────────────────────────
    // Time Handling
    // ─────────────────────────────────────────────────────────────────────

    public function test_start_time_is_formatted_correctly(): void
    {
        $booking = Booking::factory()->create(['start_time' => '10:30:00']);

        $this->assertEquals('10:30', $booking->start_time);
    }

    public function test_end_time_is_formatted_correctly(): void
    {
        $booking = Booking::factory()->create(['end_time' => '22:00:00']);

        $this->assertEquals('22:00', $booking->end_time);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_booking_can_be_soft_deleted(): void
    {
        $booking = Booking::factory()->create();
        $bookingId = $booking->id;

        $booking->delete();

        $this->assertSoftDeleted('bookings', ['id' => $bookingId]);
    }
}
