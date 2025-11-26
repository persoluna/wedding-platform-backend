<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorAvailability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_vendor_belongs_to_user(): void
    {
        $vendor = Vendor::factory()->create();

        $this->assertInstanceOf(User::class, $vendor->user);
        $this->assertEquals('vendor', $vendor->user->type);
    }

    public function test_vendor_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Photography']);
        $vendor = Vendor::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $vendor->category);
        $this->assertEquals('Photography', $vendor->category->name);
    }

    public function test_vendor_can_belong_to_owning_agency(): void
    {
        $agency = Agency::factory()->create();
        $vendor = Vendor::factory()->create(['owning_agency_id' => $agency->id]);

        $this->assertInstanceOf(Agency::class, $vendor->owningAgency);
        $this->assertEquals($agency->id, $vendor->owningAgency->id);
    }

    public function test_vendor_can_be_associated_with_multiple_agencies(): void
    {
        $vendor = Vendor::factory()->create();
        $agency1 = Agency::factory()->create();
        $agency2 = Agency::factory()->create();

        $vendor->agencies()->attach($agency1, ['status' => 'approved']);
        $vendor->agencies()->attach($agency2, ['status' => 'pending']);

        $this->assertCount(2, $vendor->agencies);
    }

    public function test_vendor_can_filter_approved_agencies(): void
    {
        $vendor = Vendor::factory()->create();
        $approved = Agency::factory()->create();
        $pending = Agency::factory()->create();

        $vendor->agencies()->attach($approved, ['status' => 'approved']);
        $vendor->agencies()->attach($pending, ['status' => 'pending']);

        $this->assertCount(1, $vendor->approvedAgencies);
        $this->assertEquals($approved->id, $vendor->approvedAgencies->first()->id);
    }

    public function test_vendor_has_many_inquiries(): void
    {
        $vendor = Vendor::factory()->create();
        Inquiry::factory()->count(3)->create(['vendor_id' => $vendor->id]);

        $this->assertCount(3, $vendor->inquiries);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Rating Stats
    // ─────────────────────────────────────────────────────────────────────

    public function test_update_rating_stats_calculates_correctly(): void
    {
        $vendor = Vendor::factory()->create();

        Review::factory()->forVendor($vendor)->approved()->withRating(5)->create();
        Review::factory()->forVendor($vendor)->approved()->withRating(5)->create();
        Review::factory()->forVendor($vendor)->approved()->withRating(4)->create();
        // Unapproved review should not count
        Review::factory()->forVendor($vendor)->withRating(1)->create();

        $vendor->updateRatingStats();

        $this->assertEquals(4.67, round($vendor->avg_rating, 2));
        $this->assertEquals(3, $vendor->review_count);
    }

    public function test_update_rating_stats_handles_no_reviews(): void
    {
        $vendor = Vendor::factory()->create();

        $vendor->updateRatingStats();

        $this->assertEquals(0, $vendor->avg_rating);
        $this->assertEquals(0, $vendor->review_count);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Views Counter
    // ─────────────────────────────────────────────────────────────────────

    public function test_increment_views_count(): void
    {
        $vendor = Vendor::factory()->create(['views_count' => 0]);

        $vendor->incrementViewsCount();

        $this->assertEquals(1, $vendor->fresh()->views_count);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Availability
    // ─────────────────────────────────────────────────────────────────────

    public function test_is_available_on_returns_true_when_no_record_exists(): void
    {
        $vendor = Vendor::factory()->create();
        $date = now()->addMonth()->toDateString();

        $this->assertTrue($vendor->isAvailableOn($date));
    }

    public function test_is_available_on_returns_true_when_status_is_available(): void
    {
        $vendor = Vendor::factory()->create();
        $date = now()->addMonth()->toDateString();

        VendorAvailability::create([
            'vendor_id' => $vendor->id,
            'date' => $date,
            'status' => 'available',
        ]);

        $this->assertTrue($vendor->isAvailableOn($date));
    }

    public function test_is_available_on_returns_true_when_partially_booked(): void
    {
        $vendor = Vendor::factory()->create();
        $date = now()->addMonth()->toDateString();

        VendorAvailability::create([
            'vendor_id' => $vendor->id,
            'date' => $date,
            'status' => 'partially_booked',
        ]);

        $this->assertTrue($vendor->isAvailableOn($date));
    }

    public function test_is_available_on_returns_false_when_fully_booked(): void
    {
        $vendor = Vendor::factory()->create();
        $date = now()->addMonth()->toDateString();

        VendorAvailability::create([
            'vendor_id' => $vendor->id,
            'date' => $date,
            'status' => 'fully_booked',
        ]);

        $this->assertFalse($vendor->isAvailableOn($date));
    }

    // ─────────────────────────────────────────────────────────────────────
    // Pricing
    // ─────────────────────────────────────────────────────────────────────

    public function test_vendor_has_price_range(): void
    {
        $vendor = Vendor::factory()->withPriceRange(50000, 200000)->create();

        $this->assertEquals(50000, $vendor->min_price);
        $this->assertEquals(200000, $vendor->max_price);
    }

    public function test_price_unit_defaults_to_per_event(): void
    {
        $vendor = Vendor::factory()->create();

        $this->assertEquals('per event', $vendor->price_unit);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Subscription Status
    // ─────────────────────────────────────────────────────────────────────

    public function test_vendor_subscription_defaults_to_free(): void
    {
        $vendor = Vendor::factory()->create();

        $this->assertEquals('free', $vendor->subscription_status);
    }

    public function test_premium_vendor_has_subscription_expiry(): void
    {
        $vendor = Vendor::factory()->premium()->create();

        $this->assertEquals('premium', $vendor->subscription_status);
        $this->assertNotNull($vendor->subscription_expires_at);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_vendor_can_be_soft_deleted(): void
    {
        $vendor = Vendor::factory()->create();
        $vendorId = $vendor->id;

        $vendor->delete();

        $this->assertSoftDeleted('vendors', ['id' => $vendorId]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // JSON Attributes
    // ─────────────────────────────────────────────────────────────────────

    public function test_vendor_attributes_cast_to_json(): void
    {
        $vendor = Vendor::factory()->create([
            'attributes' => [
                'studio_size' => 'large',
                'equipment' => ['canon', 'sony'],
            ],
        ]);

        $fresh = $vendor->fresh();

        $this->assertIsArray($fresh->attributes);
        $this->assertEquals('large', $fresh->attributes['studio_size']);
        $this->assertContains('canon', $fresh->attributes['equipment']);
    }
}
