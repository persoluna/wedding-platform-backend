<?php

namespace Tests\Unit\Models;

use App\Models\Agency;
use App\Models\Client;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────
    // Type Helpers
    // ─────────────────────────────────────────────────────────────────────

    public function test_is_admin_returns_true_for_admin_type(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isAgency());
        $this->assertFalse($user->isVendor());
        $this->assertFalse($user->isClient());
    }

    public function test_is_agency_returns_true_for_agency_type(): void
    {
        $user = User::factory()->agency()->create();

        $this->assertTrue($user->isAgency());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isVendor());
        $this->assertFalse($user->isClient());
    }

    public function test_is_vendor_returns_true_for_vendor_type(): void
    {
        $user = User::factory()->vendor()->create();

        $this->assertTrue($user->isVendor());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isAgency());
        $this->assertFalse($user->isClient());
    }

    public function test_is_client_returns_true_for_client_type(): void
    {
        $user = User::factory()->client()->create();

        $this->assertTrue($user->isClient());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isAgency());
        $this->assertFalse($user->isVendor());
    }

    // ─────────────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────────────

    public function test_user_can_have_agency_relationship(): void
    {
        $user = User::factory()->agency()->create();
        $agency = Agency::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Agency::class, $user->agency);
        $this->assertEquals($agency->id, $user->agency->id);
    }

    public function test_user_can_have_vendor_relationship(): void
    {
        $user = User::factory()->vendor()->create();
        $vendor = Vendor::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Vendor::class, $user->vendor);
        $this->assertEquals($vendor->id, $user->vendor->id);
    }

    public function test_user_can_have_client_relationship(): void
    {
        $user = User::factory()->client()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Client::class, $user->client);
        $this->assertEquals($client->id, $user->client->id);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Soft Deletes
    // ─────────────────────────────────────────────────────────────────────

    public function test_user_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
        $this->assertNull(User::find($userId));
        $this->assertNotNull(User::withTrashed()->find($userId));
    }

    public function test_soft_deleted_user_can_be_restored(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $user->restore();

        $this->assertNotSoftDeleted('users', ['id' => $user->id]);
        $this->assertNotNull(User::find($user->id));
    }

    // ─────────────────────────────────────────────────────────────────────
    // Active State
    // ─────────────────────────────────────────────────────────────────────

    public function test_user_active_defaults_to_true(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->active);
    }

    public function test_user_can_be_inactive(): void
    {
        $user = User::factory()->inactive()->create();

        $this->assertFalse($user->active);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Password Hashing
    // ─────────────────────────────────────────────────────────────────────

    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => 'plaintext']);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(password_verify('plaintext', $user->password));
    }
}
