<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DemoBookingSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo bookings already exist
        if (Booking::count() > 0) {
            $this->command->info('⏭ Demo bookings already seeded, skipping...');
            return;
        }

        $clients = Client::with('user')->get();
        $vendors = Vendor::with(['user', 'category'])->get();
        $agencies = Agency::with('user')->get();

        // Get inquiries that should have bookings
        $respondedInquiries = Inquiry::whereIn('status', ['responded', 'in_progress', 'booked'])
            ->with(['client', 'vendor', 'agency'])
            ->get();

        $bookingCount = 0;

        // ═══════════════════════════════════════════════════════════════════
        // BOOKINGS FROM INQUIRIES (Realistic flow)
        // ═══════════════════════════════════════════════════════════════════

        // Convert some inquiries to bookings (40% conversion rate)
        $bookedInquiries = $respondedInquiries->filter(fn() => rand(1, 100) <= 40);

        foreach ($bookedInquiries as $inquiry) {
            $client = $inquiry->client;
            if (!$client) continue;

            $bookable = $inquiry->vendor ?? $inquiry->agency;
            if (!$bookable) continue;

            $baseAmount = $this->calculateAmount($bookable);
            $depositAmount = $baseAmount * 0.25; // 25% deposit
            $balanceAmount = $baseAmount - $depositAmount;

            // Determine booking status based on wedding date
            $weddingDate = $client->wedding_date;
            if (!$weddingDate) continue;

            if ($weddingDate->isPast()) {
                $status = rand(1, 100) <= 90 ? 'completed' : 'cancelled';
            } elseif ($weddingDate->isBetween(now(), now()->addMonth())) {
                $status = 'confirmed';
            } else {
                $status = rand(1, 100) <= 70 ? 'confirmed' : 'pending';
            }

            $booking = Booking::create([
                'client_id' => $client->id,
                'bookable_id' => $bookable->id,
                'bookable_type' => get_class($bookable),
                'inquiry_id' => $inquiry->id,
                'event_date' => $weddingDate,
                'event_location' => $client->wedding_venue ?? $client->wedding_city,
                'start_time' => $this->getEventStartTime($bookable),
                'end_time' => $this->getEventEndTime($bookable),
                'amount' => $baseAmount,
                'deposit_amount' => $depositAmount,
                'balance_amount' => $balanceAmount,
                'status' => $status,
                'notes' => $this->generateBookingNotes($client, $bookable),
                'client_notes' => $this->getClientNotes(),
                'vendor_notes' => $this->getVendorNotes($status),
                'terms_and_conditions' => $this->getTerms($bookable),
                'deposit_paid_at' => in_array($status, ['confirmed', 'completed']) ? now()->subDays(rand(30, 90)) : null,
                'full_payment_received_at' => $status === 'completed' ? $weddingDate->subDays(rand(1, 7)) : null,
                'created_at' => now()->subDays(rand(30, 120)),
            ]);

            // Mark inquiry as booked
            $inquiry->update([
                'status' => 'booked',
                'closed_at' => $booking->created_at,
            ]);

            $bookingCount++;
        }

        // ═══════════════════════════════════════════════════════════════════
        // ADDITIONAL DIRECT BOOKINGS (Past completed weddings for reviews)
        // ═══════════════════════════════════════════════════════════════════

        // Get clients with past wedding dates for completed bookings
        $pastClients = $clients->filter(fn($c) => $c->wedding_date?->isPast());

        foreach ($pastClients as $client) {
            // Each past wedding should have 3-6 vendor bookings
            $numBookings = rand(3, 6);
            $bookedVendorIds = Booking::where('client_id', $client->id)
                ->whereNotNull('bookable_id')
                ->pluck('bookable_id')
                ->toArray();

            $availableVendors = $vendors->whereNotIn('id', $bookedVendorIds)->shuffle()->take($numBookings);

            foreach ($availableVendors as $vendor) {
                $baseAmount = $this->calculateAmount($vendor);
                $depositAmount = $baseAmount * 0.25;
                $balanceAmount = $baseAmount - $depositAmount;

                Booking::create([
                    'client_id' => $client->id,
                    'bookable_id' => $vendor->id,
                    'bookable_type' => Vendor::class,
                    'event_date' => $client->wedding_date,
                    'event_location' => $client->wedding_venue ?? $client->wedding_city,
                    'start_time' => $this->getEventStartTime($vendor),
                    'end_time' => $this->getEventEndTime($vendor),
                    'amount' => $baseAmount,
                    'deposit_amount' => $depositAmount,
                    'balance_amount' => $balanceAmount,
                    'status' => 'completed',
                    'notes' => $this->generateBookingNotes($client, $vendor),
                    'terms_and_conditions' => $this->getTerms($vendor),
                    'deposit_paid_at' => $client->wedding_date?->subDays(rand(45, 90)),
                    'full_payment_received_at' => $client->wedding_date?->subDays(rand(3, 14)),
                    'created_at' => $client->wedding_date?->subDays(rand(60, 150)),
                ]);

                $bookingCount++;
            }

            // Also add agency booking for some past clients
            if (rand(1, 100) <= 50 && $pastClients->count() > 0) {
                $agency = $agencies->random();
                $baseAmount = rand(3, 10) * 100000; // 3-10 lakhs for agencies

                Booking::create([
                    'client_id' => $client->id,
                    'bookable_id' => $agency->id,
                    'bookable_type' => Agency::class,
                    'event_date' => $client->wedding_date,
                    'event_location' => $client->wedding_venue ?? $client->wedding_city,
                    'amount' => $baseAmount,
                    'deposit_amount' => $baseAmount * 0.25,
                    'balance_amount' => $baseAmount * 0.75,
                    'status' => 'completed',
                    'notes' => 'Complete wedding planning and coordination services',
                    'deposit_paid_at' => $client->wedding_date?->subDays(rand(90, 180)),
                    'full_payment_received_at' => $client->wedding_date?->subDays(rand(7, 30)),
                    'created_at' => $client->wedding_date?->subDays(rand(120, 240)),
                ]);

                $bookingCount++;
            }
        }

        // ═══════════════════════════════════════════════════════════════════
        // UPCOMING BOOKINGS FOR ACTIVE CLIENTS
        // ═══════════════════════════════════════════════════════════════════

        $futureClients = $clients->filter(fn($c) => $c->wedding_date?->isFuture());

        foreach ($futureClients as $client) {
            // Future weddings should have 2-4 confirmed vendor bookings
            $numBookings = rand(2, 4);
            $bookedVendorIds = Booking::where('client_id', $client->id)->pluck('bookable_id')->toArray();

            $availableVendors = $vendors->whereNotIn('id', $bookedVendorIds)->shuffle()->take($numBookings);

            foreach ($availableVendors as $vendor) {
                $baseAmount = $this->calculateAmount($vendor);
                $depositAmount = $baseAmount * 0.25;
                $balanceAmount = $baseAmount - $depositAmount;

                $status = rand(1, 100) <= 75 ? 'confirmed' : 'pending';
                $depositPaid = $status === 'confirmed' || rand(1, 100) <= 40;

                Booking::create([
                    'client_id' => $client->id,
                    'bookable_id' => $vendor->id,
                    'bookable_type' => Vendor::class,
                    'event_date' => $client->wedding_date,
                    'event_location' => $client->wedding_venue ?? $client->wedding_city,
                    'start_time' => $this->getEventStartTime($vendor),
                    'end_time' => $this->getEventEndTime($vendor),
                    'amount' => $baseAmount,
                    'deposit_amount' => $depositAmount,
                    'balance_amount' => $depositPaid ? $balanceAmount : $baseAmount,
                    'status' => $status,
                    'notes' => $this->generateBookingNotes($client, $vendor),
                    'client_notes' => $this->getClientNotes(),
                    'vendor_notes' => $status === 'pending' ? 'Awaiting deposit payment confirmation' : null,
                    'terms_and_conditions' => $this->getTerms($vendor),
                    'deposit_paid_at' => $depositPaid ? now()->subDays(rand(7, 45)) : null,
                    'created_at' => now()->subDays(rand(14, 90)),
                ]);

                $bookingCount++;
            }
        }

        $this->command->info('✓ Created ' . $bookingCount . ' bookings');
    }

    private function calculateAmount($bookable): float
    {
        if ($bookable instanceof Vendor) {
            // Use vendor's pricing
            $minPrice = $bookable->min_price ?? 50000;
            $maxPrice = $bookable->max_price ?? $minPrice * 2;
            return rand((int)$minPrice, (int)$maxPrice);
        }

        // Agency pricing
        return rand(3, 15) * 100000;
    }

    private function getEventStartTime($bookable): string
    {
        $category = $bookable->category->name ?? '';

        // Different start times based on service type
        if (str_contains($category, 'Photo') || str_contains($category, 'Video')) {
            return collect(['06:00', '07:00', '08:00', '09:00'])->random();
        }
        if (str_contains($category, 'DJ') || str_contains($category, 'Band')) {
            return collect(['19:00', '20:00', '21:00'])->random();
        }
        if (str_contains($category, 'Makeup')) {
            return collect(['04:00', '05:00', '06:00'])->random();
        }
        if (str_contains($category, 'Cater')) {
            return collect(['11:00', '12:00', '18:00', '19:00'])->random();
        }

        return collect(['09:00', '10:00', '11:00', '18:00', '19:00'])->random();
    }

    private function getEventEndTime($bookable): string
    {
        $category = $bookable->category->name ?? '';

        if (str_contains($category, 'Photo') || str_contains($category, 'Video')) {
            return collect(['22:00', '23:00', '00:00'])->random();
        }
        if (str_contains($category, 'DJ') || str_contains($category, 'Band')) {
            return collect(['23:00', '00:00', '01:00'])->random();
        }
        if (str_contains($category, 'Makeup')) {
            return collect(['10:00', '11:00', '12:00'])->random();
        }
        if (str_contains($category, 'Cater')) {
            return collect(['15:00', '16:00', '23:00', '00:00'])->random();
        }

        return collect(['18:00', '21:00', '23:00'])->random();
    }

    private function generateBookingNotes(Client $client, $bookable): string
    {
        $category = $bookable->category->name ?? 'service';
        $notes = [];

        $notes[] = ucfirst($category) . ' services for ' . ($client->wedding_type ?? 'wedding');

        if ($client->guest_count) {
            $notes[] = 'Guest count: ' . $client->guest_count;
        }

        $serviceNotes = [
            'Photo' => ['Candid + traditional coverage', '2 photographers assigned', 'Drone coverage included', 'Same-day edit requested'],
            'Cater' => ['Vegetarian and non-veg menu', 'Live counters included', 'Special dietary requirements noted', 'Chaat counter requested'],
            'Makeup' => ['HD airbrush makeup', 'Trial completed', 'Hairstyling included', 'Touch-up kit provided'],
            'Decor' => ['Theme: ' . collect(['Royal', 'Pastel', 'Traditional', 'Modern'])->random(), 'Fresh flowers only', 'Mandap + stage + entrance'],
            'DJ' => ['Full sound system', 'Lights package included', 'MC services added', 'Playlist pre-approved'],
            'Venue' => ['Exclusive booking', 'Valet parking included', 'Bridal room reserved', 'Backup generator arranged'],
            'Mehndi' => ['Full bridal mehndi with portrait', 'Family mehndi included', 'Organic henna used'],
            'Pandit' => ['Full ceremony 2.5 hours', 'All rituals with explanation', 'Samagri arranged'],
        ];

        foreach ($serviceNotes as $pattern => $options) {
            if (str_contains($category, $pattern)) {
                $notes[] = collect($options)->random(rand(1, 2))->implode('. ');
                break;
            }
        }

        return implode("\n", $notes);
    }

    private function getClientNotes(): ?string
    {
        $notes = [
            'Please coordinate with wedding planner for timing',
            'Groom\'s family arriving from outstation - may need flexible timing',
            'Bride has specific requirements discussed during consultation',
            'Photography team should coordinate with them',
            'Special attention needed for elderly family members',
            'Parking arrangements confirmed with venue',
            null,
            null,
        ];

        return collect($notes)->random();
    }

    private function getVendorNotes(?string $status): ?string
    {
        if ($status === 'pending') {
            return collect([
                'Awaiting final confirmation',
                'Deposit invoice sent',
                'Following up on requirements',
            ])->random();
        }

        if ($status === 'confirmed') {
            return collect([
                'Team assigned: Raj, Priya, Amit',
                'Equipment reserved',
                'Pre-event recce scheduled',
                'All requirements confirmed',
                null,
            ])->random();
        }

        if ($status === 'completed') {
            return collect([
                'Successfully completed',
                'Client satisfied with services',
                'Photos/deliverables shared',
                'Final payment received',
                null,
            ])->random();
        }

        return null;
    }

    private function getTerms($bookable): string
    {
        $businessName = $bookable->business_name;

        return "TERMS & CONDITIONS - {$businessName}

1. BOOKING & PAYMENT
- 25% advance payment required to confirm booking
- 50% payment due 2 weeks before the event
- Balance 25% due on event day / within 7 days of completion
- Cancellation within 30 days: 50% refund of deposit
- Cancellation within 15 days: No refund

2. SERVICE DELIVERY
- Timelines will be coordinated with client/wedding planner
- Any delays caused by client will not affect service charges
- Additional hours will be charged at agreed hourly rate

3. RESCHEDULE POLICY
- One free reschedule allowed if notified 30+ days in advance
- Reschedule subject to availability

4. FORCE MAJEURE
- Neither party liable for non-performance due to circumstances beyond control

By proceeding with this booking, client agrees to these terms.";
    }
}
