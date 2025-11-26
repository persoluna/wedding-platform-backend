<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Skip if categories already exist
        if (Category::count() > 5) {
            $this->command->info('⏭ Categories already seeded, skipping...');
            return;
        }

        $categories = [
            [
                'name' => 'Photography & Videography',
                'description' => 'Capture every precious moment of your special day with professional photographers and videographers',
                'icon' => 'heroicon-o-camera',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Wedding Photographers', 'description' => 'Professional wedding photography services'],
                    ['name' => 'Cinematographers', 'description' => 'Cinematic wedding films and videography'],
                    ['name' => 'Pre-Wedding Shoots', 'description' => 'Pre-wedding and engagement photo sessions'],
                    ['name' => 'Drone Photography', 'description' => 'Aerial photography and videography services'],
                    ['name' => 'Photo Booths', 'description' => 'Fun photo booth rentals for wedding events'],
                ],
            ],
            [
                'name' => 'Venues & Banquets',
                'description' => 'Find the perfect venue for your dream wedding celebration',
                'icon' => 'heroicon-o-building-office-2',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Banquet Halls', 'description' => 'Indoor banquet halls and ballrooms'],
                    ['name' => 'Farmhouses & Resorts', 'description' => 'Scenic farmhouses and resort venues'],
                    ['name' => 'Hotels', 'description' => 'Luxury hotel wedding venues'],
                    ['name' => 'Destination Venues', 'description' => 'Destination wedding locations'],
                    ['name' => 'Heritage Properties', 'description' => 'Palace and heritage venue rentals'],
                    ['name' => 'Beach & Garden Venues', 'description' => 'Outdoor beach and garden wedding venues'],
                ],
            ],
            [
                'name' => 'Catering & Food',
                'description' => 'Delight your guests with exquisite cuisines and catering services',
                'icon' => 'heroicon-o-cake',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Wedding Caterers', 'description' => 'Full-service wedding catering'],
                    ['name' => 'Multi-Cuisine Caterers', 'description' => 'Indian and international cuisine specialists'],
                    ['name' => 'Chaat & Street Food', 'description' => 'Live chaat counters and street food stalls'],
                    ['name' => 'Wedding Cakes', 'description' => 'Custom wedding cakes and desserts'],
                    ['name' => 'Bartenders & Beverages', 'description' => 'Bar services and mocktail counters'],
                ],
            ],
            [
                'name' => 'Makeup & Mehndi',
                'description' => 'Look your absolute best with expert makeup artists and mehndi designers',
                'icon' => 'heroicon-o-sparkles',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Bridal Makeup Artists', 'description' => 'Professional bridal makeup services'],
                    ['name' => 'Mehndi Artists', 'description' => 'Traditional and contemporary mehndi designs'],
                    ['name' => 'Hair Stylists', 'description' => 'Bridal hair styling and grooming'],
                    ['name' => 'Family Makeup', 'description' => 'Makeup for family members and bridesmaids'],
                ],
            ],
            [
                'name' => 'Decoration & Flowers',
                'description' => 'Transform your venue into a magical wonderland',
                'icon' => 'heroicon-o-gift',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Wedding Decorators', 'description' => 'Complete venue decoration services'],
                    ['name' => 'Florists', 'description' => 'Floral arrangements and flower decoration'],
                    ['name' => 'Mandap Decoration', 'description' => 'Traditional mandap and stage decoration'],
                    ['name' => 'Lighting & Effects', 'description' => 'Lighting design and special effects'],
                    ['name' => 'Entrance Decor', 'description' => 'Grand entrance and gate decoration'],
                ],
            ],
            [
                'name' => 'Music & Entertainment',
                'description' => 'Keep your guests entertained throughout the celebration',
                'icon' => 'heroicon-o-musical-note',
                'is_featured' => true,
                'children' => [
                    ['name' => 'DJs', 'description' => 'Professional DJ services for weddings'],
                    ['name' => 'Live Bands', 'description' => 'Live music bands and orchestras'],
                    ['name' => 'Dhol Players', 'description' => 'Traditional dhol and baraat music'],
                    ['name' => 'Sangeet Choreographers', 'description' => 'Choreography for sangeet performances'],
                    ['name' => 'Anchor & Emcees', 'description' => 'Professional wedding hosts and emcees'],
                    ['name' => 'Fireworks & Pyro', 'description' => 'Fireworks and pyrotechnics for celebrations'],
                ],
            ],
            [
                'name' => 'Bridal Wear & Fashion',
                'description' => 'Find the perfect wedding attire for the bride, groom, and family',
                'icon' => 'heroicon-o-heart',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Bridal Lehengas', 'description' => 'Designer bridal lehengas and sarees'],
                    ['name' => 'Groom Wear', 'description' => 'Sherwanis, suits, and groom attire'],
                    ['name' => 'Jewellery', 'description' => 'Bridal and artificial jewellery'],
                    ['name' => 'Trousseau Packing', 'description' => 'Wedding gift and trousseau packing'],
                ],
            ],
            [
                'name' => 'Wedding Planning',
                'description' => 'Let professionals handle all aspects of your wedding',
                'icon' => 'heroicon-o-clipboard-document-list',
                'is_featured' => true,
                'children' => [
                    ['name' => 'Full Wedding Planners', 'description' => 'End-to-end wedding planning services'],
                    ['name' => 'Day-of Coordinators', 'description' => 'On-the-day wedding coordination'],
                    ['name' => 'Destination Wedding Planners', 'description' => 'Specialists in destination weddings'],
                ],
            ],
            [
                'name' => 'Invitations & Stationery',
                'description' => 'Beautiful wedding invitations and stationery',
                'icon' => 'heroicon-o-envelope',
                'is_featured' => false,
                'children' => [
                    ['name' => 'Wedding Cards', 'description' => 'Printed wedding invitation cards'],
                    ['name' => 'E-Invites', 'description' => 'Digital wedding invitations and videos'],
                    ['name' => 'Save the Date', 'description' => 'Save the date cards and announcements'],
                ],
            ],
            [
                'name' => 'Transportation',
                'description' => 'Arrive in style with luxury wedding transportation',
                'icon' => 'heroicon-o-truck',
                'is_featured' => false,
                'children' => [
                    ['name' => 'Luxury Cars', 'description' => 'Luxury car rentals for wedding'],
                    ['name' => 'Vintage Cars', 'description' => 'Classic and vintage car services'],
                    ['name' => 'Doli & Palki', 'description' => 'Traditional doli and palki services'],
                    ['name' => 'Guest Transportation', 'description' => 'Bus and van rentals for guests'],
                ],
            ],
            [
                'name' => 'Pandits & Religious Services',
                'description' => 'Traditional wedding ceremonies and religious services',
                'icon' => 'heroicon-o-sun',
                'is_featured' => false,
                'children' => [
                    ['name' => 'Wedding Pandits', 'description' => 'Experienced pandits for Hindu weddings'],
                    ['name' => 'Havan & Pooja Services', 'description' => 'Pre-wedding ceremony services'],
                    ['name' => 'Christian Officiants', 'description' => 'Christian wedding officiants'],
                    ['name' => 'Muslim Qazis', 'description' => 'Nikah ceremony services'],
                ],
            ],
            [
                'name' => 'Gifts & Favors',
                'description' => 'Wedding favors, gifts, and return presents',
                'icon' => 'heroicon-o-gift-top',
                'is_featured' => false,
                'children' => [
                    ['name' => 'Wedding Favors', 'description' => 'Guest favors and return gifts'],
                    ['name' => 'Gift Hampers', 'description' => 'Customized gift hampers'],
                    ['name' => 'Personalized Gifts', 'description' => 'Custom wedding gifts and memorabilia'],
                ],
            ],
        ];

        $sortOrder = 1;

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create([
                ...$categoryData,
                'slug' => Str::slug($categoryData['name']),
                'sort_order' => $sortOrder++,
                'active' => true,
            ]);

            $childSortOrder = 1;
            foreach ($children as $childData) {
                Category::create([
                    ...$childData,
                    'slug' => Str::slug($childData['name']),
                    'parent_id' => $category->id,
                    'sort_order' => $childSortOrder++,
                    'active' => true,
                    'is_featured' => false,
                ]);
            }
        }

        $this->command->info('✓ Created ' . Category::count() . ' categories');
    }
}
