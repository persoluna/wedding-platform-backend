<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_agency_belongs_to_user(): void
    {
        $agency = Agency::factory()->create();

        $this->assertInstanceOf(User::class, $agency->user);
        $this->assertEquals('agency', $agency->user->type);
    }

    public function test_agency_can_have_many_vendors(): void
    {
        $agency = Agency::factory()->create();
        $vendor1 = Vendor::factory()->create();
        $vendor2 = Vendor::factory()->create();

        $agency->vendors()->attach($vendor1, ['status' => 'approved']);
        $agency->vendors()->attach($vendor2, ['status' => 'pending']);

        $this->assertCount(2, $agency->vendors);
    }

    public function test_agency_can_filter_approved_vendors(): void
    {
        $agency = Agency::factory()->create();
        $approved = Vendor::factory()->create();
        $pending = Vendor::factory()->create();

        $agency->vendors()->attach($approved, ['status' => 'approved']);
        $agency->vendors()->attach($pending, ['status' => 'pending']);

        $this->assertCount(1, $agency->approvedVendors);
        $this->assertEquals($approved->id, $agency->approvedVendors->first()->id);
    }

    public function test_agency_can_filter_pending_vendors(): void
    {
        $agency = Agency::factory()->create();
        $approved = Vendor::factory()->create();
        $pending = Vendor::factory()->create();

        $agency->vendors()->attach($approved, ['status' => 'approved']);
        $agency->vendors()->attach($pending, ['status' => 'pending']);

        $this->assertCount(1, $agency->pendingVendors);
        $this->assertEquals($pending->id, $agency->pendingVendors->first()->id);
    }

    public function test_agency_can_own_vendors(): void
    {
        $agency = Agency::factory()->create();
        $ownedVendor = Vendor::factory()->create(['owning_agency_id' => $agency->id]);

        $this->assertCount(1, $agency->ownedVendors);
        $this->assertEquals($ownedVendor->id, $agency->ownedVendors->first()->id);
    }

    public function test_agency_has_many_inquiries(): void
    {
        $agency = Agency::factory()->create();
        Inquiry::factory()->count(3)->create(['agency_id' => $agency->id]);

        $this->assertCount(3, $agency->inquiries);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Rating Stats
    // ─────────────────────────────────────────────────────────────────────

    public function test_update_rating_stats_calculates_correctly(): void
    {
        $agency = Agency::factory()->create();

        Review::factory()->forAgency($agency)->approved()->withRating(5)->create();
        Review::factory()->forAgency($agency)->approved()->withRating(4)->create();
        Review::factory()->forAgency($agency)->approved()->withRating(3)->create();
        // Unapproved review should not count
        Review::factory()->forAgency($agency)->withRating(1)->create();

        $agency->updateRatingStats();

        $this->assertEquals(4.0, $agency->avg_rating);
        $this->assertEquals(3, $agency->review_count);
    }

    public function test_update_rating_stats_handles_no_reviews(): void
    {
        $agency = Agency::factory()->create();

        $agency->updateRatingStats();

        $this->assertEquals(0, $agency->avg_rating);
        $this->assertEquals(0, $agency->review_count);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Views Counter
    // ─────────────────────────────────────────────────────────────────────

    public function test_increment_views_count(): void
    {
        $agency = Agency::factory()->create(['views_count' => 0]);

        $agency->incrementViewsCount();

        $this->assertEquals(1, $agency->fresh()->views_count);
    }

    public function test_increment_views_count_multiple_times(): void
    {
        $agency = Agency::factory()->create(['views_count' => 10]);

        $agency->incrementViewsCount();
        $agency->incrementViewsCount();
        $agency->incrementViewsCount();

        $this->assertEquals(13, $agency->fresh()->views_count);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Subscription Status
    // ─────────────────────────────────────────────────────────────────────

    public function test_agency_subscription_defaults_to_free(): void
    {
        $agency = Agency::factory()->create();

        $this->assertEquals('free', $agency->subscription_status);
        $this->assertNull($agency->subscription_expires_at);
    }

    public function test_premium_agency_has_subscription_expiry(): void
    {
        $agency = Agency::factory()->premium()->create();

        $this->assertEquals('premium', $agency->subscription_status);
        $this->assertNotNull($agency->subscription_expires_at);
        $this->assertTrue($agency->subscription_expires_at->isFuture());
    }

    // ─────────────────────────────────────────────────────────────────────
    // Verification & Feature Flags
    // ─────────────────────────────────────────────────────────────────────

    public function test_agency_defaults_to_unverified(): void
    {
        $agency = Agency::factory()->create();

        $this->assertFalse($agency->verified);
        $this->assertFalse($agency->featured);
        $this->assertFalse($agency->premium);
    }

    public function test_verified_agency_factory_state(): void
    {
        $agency = Agency::factory()->verified()->create();

        $this->assertTrue($agency->verified);
    }

    public function test_featured_agency_factory_state(): void
    {
        $agency = Agency::factory()->featured()->create();

        $this->assertTrue($agency->featured);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_agency_can_be_soft_deleted(): void
    {
        $agency = Agency::factory()->create();
        $agencyId = $agency->id;

        $agency->delete();

        $this->assertSoftDeleted('agencies', ['id' => $agencyId]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Vendor Pivot Data
    // ─────────────────────────────────────────────────────────────────────

    public function test_agency_vendor_pivot_stores_commission_rate(): void
    {
        $agency = Agency::factory()->create();
        $vendor = Vendor::factory()->create();

        $agency->vendors()->attach($vendor, [
            'status' => 'approved',
            'commission_rate' => 15.5,
            'is_preferred' => true,
        ]);

        $attachedVendor = $agency->vendors()->first();

        $this->assertEquals(15.5, $attachedVendor->pivot->commission_rate);
        $this->assertTrue((bool) $attachedVendor->pivot->is_preferred);
    }
}
