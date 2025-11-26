<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Demo Data Seeding...');
        $this->command->newLine();

        $this->call([
            // Foundation data
            CategorySeeder::class,
            EventTypeSeeder::class,

            // Users (admins, agencies, vendors, clients)
            DemoUserSeeder::class,

            // Business entities
            DemoAgencySeeder::class,
            DemoVendorSeeder::class,

            // Client profiles
            DemoClientSeeder::class,

            // Interactions
            DemoInquirySeeder::class,
            DemoBookingSeeder::class,
            DemoReviewSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Demo data seeding completed!');
        $this->command->newLine();
        $this->command->table(
            ['Entity', 'Count'],
            [
                ['Categories', \App\Models\Category::count()],
                ['Event Types', \App\Models\EventType::count()],
                ['Users', \App\Models\User::count()],
                ['Agencies', \App\Models\Agency::count()],
                ['Vendors', \App\Models\Vendor::count()],
                ['Clients', \App\Models\Client::count()],
                ['Inquiries', \App\Models\Inquiry::count()],
                ['Bookings', \App\Models\Booking::count()],
                ['Reviews', \App\Models\Review::count()],
                ['Messages', \App\Models\Message::count()],
                ['Services', \App\Models\Service::count()],
                ['Packages', \App\Models\Package::count()],
            ]
        );

        $this->command->newLine();
        $this->command->info('📧 Demo Login Credentials:');
        $this->command->line('   Admin: admin@shaadimandap.com / password');
        $this->command->line('   Agency: vikram@dreamshaadi.in / password');
        $this->command->line('   Vendor: arjun@pixelperfect.in / password');
        $this->command->line('   Client: aarav.gupta@gmail.com / password');
        $this->command->newLine();
    }
}
