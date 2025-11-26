<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if event types already exist
        if (EventType::count() > 5) {
            $this->command->info('⏭ Event types already seeded, skipping...');
            return;
        }

        $eventTypes = [
            [
                'name' => 'Hindu Wedding',
                'description' => 'Traditional Hindu wedding ceremonies including haldi, mehndi, sangeet, and pheras',
                'icon' => 'heroicon-o-fire',
            ],
            [
                'name' => 'Muslim Wedding',
                'description' => 'Islamic wedding ceremonies including nikah and walima',
                'icon' => 'heroicon-o-moon',
            ],
            [
                'name' => 'Christian Wedding',
                'description' => 'Church weddings and Christian ceremony services',
                'icon' => 'heroicon-o-star',
            ],
            [
                'name' => 'Sikh Wedding',
                'description' => 'Anand Karaj ceremonies at Gurudwara',
                'icon' => 'heroicon-o-sun',
            ],
            [
                'name' => 'South Indian Wedding',
                'description' => 'Tamil, Telugu, Kannada, and Malayalam wedding traditions',
                'icon' => 'heroicon-o-sparkles',
            ],
            [
                'name' => 'Bengali Wedding',
                'description' => 'Traditional Bengali wedding ceremonies and rituals',
                'icon' => 'heroicon-o-heart',
            ],
            [
                'name' => 'Marwari Wedding',
                'description' => 'Rajasthani and Marwari wedding traditions',
                'icon' => 'heroicon-o-building-office',
            ],
            [
                'name' => 'Punjabi Wedding',
                'description' => 'Grand Punjabi wedding celebrations',
                'icon' => 'heroicon-o-musical-note',
            ],
            [
                'name' => 'Gujarati Wedding',
                'description' => 'Traditional Gujarati wedding ceremonies',
                'icon' => 'heroicon-o-gift',
            ],
            [
                'name' => 'Destination Wedding',
                'description' => 'Weddings at exotic destinations in India and abroad',
                'icon' => 'heroicon-o-globe-asia-australia',
            ],
            [
                'name' => 'Court Marriage',
                'description' => 'Registered marriages and court wedding services',
                'icon' => 'heroicon-o-document-text',
            ],
            [
                'name' => 'Engagement Ceremony',
                'description' => 'Ring ceremony and engagement celebration',
                'icon' => 'heroicon-o-hand-raised',
            ],
            [
                'name' => 'Reception Party',
                'description' => 'Wedding reception and celebration party',
                'icon' => 'heroicon-o-cake',
            ],
            [
                'name' => 'Haldi Ceremony',
                'description' => 'Traditional haldi ceremony celebrations',
                'icon' => 'heroicon-o-sun',
            ],
            [
                'name' => 'Sangeet & Mehndi',
                'description' => 'Sangeet night and mehndi ceremony',
                'icon' => 'heroicon-o-musical-note',
            ],
            [
                'name' => 'Pre-Wedding Party',
                'description' => 'Bachelor/bachelorette parties and pre-wedding celebrations',
                'icon' => 'heroicon-o-sparkles',
            ],
        ];

        foreach ($eventTypes as $eventType) {
            EventType::create([
                ...$eventType,
                'slug' => Str::slug($eventType['name']),
                'is_active' => true,
            ]);
        }

        $this->command->info('✓ Created ' . EventType::count() . ' event types');
    }
}
