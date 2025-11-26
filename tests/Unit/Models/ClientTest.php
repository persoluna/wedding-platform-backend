<?php

namespace Tests\Unit\Models;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_client_belongs_to_user(): void
    {
        $client = Client::factory()->create();

        $this->assertInstanceOf(User::class, $client->user);
        $this->assertEquals('client', $client->user->type);
    }

    public function test_client_has_many_inquiries(): void
    {
        $client = Client::factory()->create();
        Inquiry::factory()->count(3)->create(['client_id' => $client->id]);

        $this->assertCount(3, $client->inquiries);
    }

    public function test_client_has_many_bookings(): void
    {
        $client = Client::factory()->create();
        Booking::factory()->count(2)->create(['client_id' => $client->id]);

        $this->assertCount(2, $client->bookings);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Computed Attributes
    // ─────────────────────────────────────────────────────────────────────

    public function test_full_name_includes_partner_when_present(): void
    {
        $user = User::factory()->client()->create(['name' => 'Alice']);
        $client = Client::factory()->create([
            'user_id' => $user->id,
            'partner_name' => 'Bob',
        ]);

        $this->assertEquals('Alice & Bob', $client->full_name);
    }

    public function test_full_name_excludes_partner_when_absent(): void
    {
        $user = User::factory()->client()->create(['name' => 'Alice']);
        $client = Client::factory()->create([
            'user_id' => $user->id,
            'partner_name' => null,
        ]);

        $this->assertEquals('Alice', $client->full_name);
    }

    public function test_days_until_wedding_calculated_correctly(): void
    {
        Carbon::setTestNow('2025-06-01 12:00:00');

        $client = Client::factory()->create([
            'wedding_date' => Carbon::parse('2025-07-01'),
        ]);

        // diffInDays returns float, so we test within acceptable range
        $this->assertEqualsWithDelta(30, $client->days_until_wedding, 1);

        Carbon::setTestNow();
    }

    public function test_days_until_wedding_returns_null_when_no_date(): void
    {
        $client = Client::factory()->justEngaged()->create();

        $this->assertNull($client->days_until_wedding);
    }

    public function test_is_wedding_in_future_returns_true_for_future_date(): void
    {
        $client = Client::factory()->create([
            'wedding_date' => Carbon::now()->addMonth(),
        ]);

        $this->assertTrue($client->is_wedding_in_future);
    }

    public function test_is_wedding_in_future_returns_false_for_past_date(): void
    {
        $client = Client::factory()->completed()->create();

        $this->assertFalse($client->is_wedding_in_future);
    }

    public function test_is_wedding_in_future_returns_true_when_no_date(): void
    {
        $client = Client::factory()->justEngaged()->create();

        $this->assertTrue($client->is_wedding_in_future);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Booked Vendors Tracking
    // ─────────────────────────────────────────────────────────────────────

    public function test_add_booked_vendor_stores_in_json(): void
    {
        $client = Client::factory()->create(['booked_vendors' => null]);

        $client->addBookedVendor(123, 'Photography', '2025-06-15');

        $fresh = $client->fresh();

        $this->assertIsArray($fresh->booked_vendors);
        $this->assertCount(1, $fresh->booked_vendors);
        $this->assertEquals(123, $fresh->booked_vendors[0]['vendor_id']);
        $this->assertEquals('Photography', $fresh->booked_vendors[0]['category']);
    }

    public function test_add_booked_vendor_appends_to_existing(): void
    {
        $client = Client::factory()->create(['booked_vendors' => [
            ['vendor_id' => 100, 'category' => 'Catering'],
        ]]);

        $client->addBookedVendor(200, 'Music');

        $fresh = $client->fresh();

        $this->assertCount(2, $fresh->booked_vendors);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Planning Status
    // ─────────────────────────────────────────────────────────────────────

    public function test_planning_status_factory_states(): void
    {
        $justEngaged = Client::factory()->justEngaged()->create();
        $planning = Client::factory()->planning()->create();
        $finalizing = Client::factory()->finalizing()->create();
        $completed = Client::factory()->completed()->create();

        $this->assertEquals('just_engaged', $justEngaged->planning_status);
        $this->assertEquals('planning', $planning->planning_status);
        $this->assertEquals('finalizing', $finalizing->planning_status);
        $this->assertEquals('completed', $completed->planning_status);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Wedding Types
    // ─────────────────────────────────────────────────────────────────────

    public function test_destination_wedding_factory_state(): void
    {
        $client = Client::factory()->destinationWedding()->create();

        $this->assertEquals('destination', $client->wedding_type);
        $this->assertContains($client->wedding_city, ['Udaipur', 'Jaipur', 'Goa', 'Kerala']);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Budget
    // ─────────────────────────────────────────────────────────────────────

    public function test_budget_is_cast_to_float(): void
    {
        $client = Client::factory()->withBudget(1500000)->create();

        $this->assertIsFloat($client->budget);
        $this->assertEquals(1500000.0, $client->budget);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_client_can_be_soft_deleted(): void
    {
        $client = Client::factory()->create();
        $clientId = $client->id;

        $client->delete();

        $this->assertSoftDeleted('clients', ['id' => $clientId]);
    }
}
