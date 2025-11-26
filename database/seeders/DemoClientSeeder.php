<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoClientSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo clients already exist
        if (Client::whereHas('user', fn($q) => $q->where('email', 'aarav.gupta@gmail.com'))->exists()) {
            $this->command->info('⏭ Demo clients already seeded, skipping...');
            return;
        }

        $clients = [
            [
                'email' => 'aarav.gupta@gmail.com',
                'partner_name' => 'Riya Mehta',
                'wedding_date' => now()->addMonths(3)->setDay(15),
                'wedding_city' => 'Udaipur',
                'wedding_state' => 'Rajasthan',
                'wedding_venue' => 'The Oberoi Udaivilas',
                'guest_count' => 350,
                'budget' => 5000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Royal and Traditional',
                    'colors' => ['Gold', 'Maroon', 'Ivory'],
                    'priorities' => ['Photography', 'Venue', 'Catering'],
                ],
                'cultural_requirements' => 'Traditional Hindu ceremonies with Rajasthani elements. Need arrangements for baraat with elephants and band baaja.',
                'additional_info' => 'Destination wedding with guests traveling from Delhi and Mumbai. Need accommodation arrangements for 150 guests.',
            ],
            [
                'email' => 'ishita.sharma@gmail.com',
                'partner_name' => 'Arnav Kapoor',
                'wedding_date' => now()->addMonths(2)->setDay(20),
                'wedding_city' => 'Mumbai',
                'wedding_state' => 'Maharashtra',
                'wedding_venue' => 'Taj Lands End',
                'guest_count' => 500,
                'budget' => 8000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Grand Bollywood Style',
                    'colors' => ['Pink', 'Gold', 'Silver'],
                    'priorities' => ['Entertainment', 'Décor', 'Photography'],
                ],
                'cultural_requirements' => 'Big fat Punjabi wedding! Need dhol players, great DJ, and lots of dancing. Sangeet is the most important event for us.',
                'additional_info' => 'The groom\'s family is from Chandigarh and will have 200 guests from there.',
            ],
            [
                'email' => 'rohan.m@yahoo.com',
                'partner_name' => 'Aisha Khan',
                'wedding_date' => now()->addMonths(4)->setDay(8),
                'wedding_city' => 'Hyderabad',
                'wedding_state' => 'Telangana',
                'wedding_venue' => 'Taj Falaknuma Palace',
                'guest_count' => 250,
                'budget' => 4500000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Elegant Nizami Style',
                    'colors' => ['White', 'Gold', 'Emerald Green'],
                    'priorities' => ['Venue', 'Catering', 'Bridal Makeup'],
                ],
                'cultural_requirements' => 'Traditional Nikah ceremony followed by grand Walima. Halal catering essential. Need qazi arrangements.',
                'additional_info' => 'Bride\'s family from Mumbai, groom\'s family from Hyderabad. Looking for authentic Hyderabadi biryani for walima.',
            ],
            [
                'email' => 'ananya.reddy@gmail.com',
                'partner_name' => 'Vikrant Rao',
                'wedding_date' => now()->addMonths(5)->setDay(12),
                'wedding_city' => 'Chennai',
                'wedding_state' => 'Tamil Nadu',
                'wedding_venue' => 'ITC Grand Chola',
                'guest_count' => 800,
                'budget' => 6000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Traditional with Modern Touch',
                    'colors' => ['Red', 'Gold', 'White'],
                    'priorities' => ['Catering', 'Traditional Décor', 'Photography'],
                ],
                'cultural_requirements' => 'Traditional Telugu Brahmin wedding. Need muhurtham at 6:42 AM. Arrange for nadaswaram and traditional items.',
                'additional_info' => 'Large joint family wedding. Morning ceremony followed by evening reception. Need separate arrangements for both.',
            ],
            [
                'email' => 'vivaan.p@outlook.com',
                'partner_name' => 'Meera Sharma',
                'wedding_date' => now()->addMonths(6)->setDay(25),
                'wedding_city' => 'Goa',
                'wedding_state' => 'Goa',
                'wedding_venue' => 'W Goa',
                'guest_count' => 120,
                'budget' => 3500000,
                'wedding_type' => 'destination',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Beach Bohemian',
                    'colors' => ['White', 'Coral', 'Turquoise'],
                    'priorities' => ['Venue', 'Photography', 'Entertainment'],
                ],
                'cultural_requirements' => 'Fusion wedding combining Hindu rituals with beach ceremony. Looking for a relaxed, vacation-like vibe.',
                'additional_info' => 'Intimate wedding with close family and friends. Want 3-day celebration with pool party and beach events.',
            ],
            [
                'email' => 'diya.kapoor@gmail.com',
                'partner_name' => 'Rahul Singhania',
                'wedding_date' => now()->addMonths(1)->setDay(10),
                'wedding_city' => 'Delhi',
                'wedding_state' => 'Delhi',
                'wedding_venue' => 'The Leela Palace',
                'guest_count' => 600,
                'budget' => 10000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Luxury Contemporary',
                    'colors' => ['Pastel Pink', 'White', 'Gold'],
                    'priorities' => ['Décor', 'Photography', 'Catering'],
                ],
                'cultural_requirements' => 'Marwari wedding traditions. Need complete haldi, mehndi, sangeet, wedding, and reception arrangements.',
                'additional_info' => 'High-profile business family wedding. Privacy and VIP arrangements important. Celebrity guest list.',
            ],
            [
                'email' => 'aditya.singh@gmail.com',
                'partner_name' => 'Tara Verma',
                'wedding_date' => now()->addMonths(7)->setDay(5),
                'wedding_city' => 'Jaipur',
                'wedding_state' => 'Rajasthan',
                'wedding_venue' => 'Samode Palace',
                'guest_count' => 200,
                'budget' => 7500000,
                'wedding_type' => 'traditional',
                'planning_status' => 'just_engaged',
                'preferences' => [
                    'style' => 'Vintage Royal',
                    'colors' => ['Deep Red', 'Gold', 'Emerald'],
                    'priorities' => ['Venue', 'Photography', 'Traditional Elements'],
                ],
                'cultural_requirements' => 'Want a royal palace wedding with traditional Rajasthani elements - folk dancers, puppet shows, traditional welcome.',
                'additional_info' => 'Both families based in Bangalore. Entire wedding is a destination event for all guests.',
            ],
            [
                'email' => 'priyanka.j@yahoo.com',
                'partner_name' => 'Nikhil Agarwal',
                'wedding_date' => now()->addMonths(2)->setDay(28),
                'wedding_city' => 'Bangalore',
                'wedding_state' => 'Karnataka',
                'wedding_venue' => 'The Ritz-Carlton',
                'guest_count' => 300,
                'budget' => 4000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Modern Minimalist',
                    'colors' => ['Ivory', 'Sage Green', 'Blush'],
                    'priorities' => ['Photography', 'Intimate Vibe', 'Food'],
                ],
                'cultural_requirements' => 'Mix of Maharashtrian and North Indian traditions. Both sets of ceremonies should be conducted.',
                'additional_info' => 'Both of us are IT professionals. Want a sophisticated wedding that reflects our personalities.',
            ],
            [
                'email' => 'aryan.verma@gmail.com',
                'partner_name' => 'Kavya Nair',
                'wedding_date' => now()->addMonths(8)->setDay(18),
                'wedding_city' => 'Kochi',
                'wedding_state' => 'Kerala',
                'wedding_venue' => 'Kumarakom Lake Resort',
                'guest_count' => 180,
                'budget' => 3000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'just_engaged',
                'preferences' => [
                    'style' => 'Kerala Traditional',
                    'colors' => ['Gold', 'White', 'Green'],
                    'priorities' => ['Traditional Ceremony', 'Sadya', 'Photography'],
                ],
                'cultural_requirements' => 'Traditional Kerala Hindu wedding. Bride will wear kasavu saree. Need proper temple-style mandap.',
                'additional_info' => 'Groom\'s family from Delhi, bride\'s family from Kerala. Need to balance both cultural elements.',
            ],
            [
                'email' => 'saanvi.iyer@gmail.com',
                'partner_name' => 'Karthik Krishnan',
                'wedding_date' => now()->addMonths(3)->setDay(22),
                'wedding_city' => 'Coimbatore',
                'wedding_state' => 'Tamil Nadu',
                'wedding_venue' => 'Le Meridien',
                'guest_count' => 500,
                'budget' => 3500000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Traditional Tamil',
                    'colors' => ['Red', 'Gold', 'White'],
                    'priorities' => ['Catering', 'Décor', 'Music'],
                ],
                'cultural_requirements' => 'Tamil Brahmin Iyengar wedding. Morning muhurtham. Need full traditional setup with koorai saree.',
                'additional_info' => 'Simple, traditional wedding focusing on rituals. Reception will be more grand.',
            ],
            [
                'email' => 'kabir.khan@gmail.com',
                'partner_name' => 'Zara Ahmed',
                'wedding_date' => now()->addMonths(4)->setDay(30),
                'wedding_city' => 'Lucknow',
                'wedding_state' => 'Uttar Pradesh',
                'wedding_venue' => 'Vivanta Lucknow',
                'guest_count' => 400,
                'budget' => 4500000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Lucknowi Elegant',
                    'colors' => ['Ivory', 'Gold', 'Blush Pink'],
                    'priorities' => ['Catering', 'Décor', 'Photography'],
                ],
                'cultural_requirements' => 'Traditional Muslim wedding with Nikah and Walima. Authentic Lucknowi cuisine is essential.',
                'additional_info' => 'Want the old-world Lucknow charm reflected in décor and food. Qawwali night before wedding.',
            ],
            [
                'email' => 'myra.s@outlook.com',
                'partner_name' => 'Dev Malhotra',
                'wedding_date' => now()->addMonths(5)->setDay(8),
                'wedding_city' => 'Amritsar',
                'wedding_state' => 'Punjab',
                'wedding_venue' => 'The Grand Amritsar',
                'guest_count' => 700,
                'budget' => 5500000,
                'wedding_type' => 'traditional',
                'planning_status' => 'planning',
                'preferences' => [
                    'style' => 'Grand Punjabi',
                    'colors' => ['Red', 'Gold', 'Orange'],
                    'priorities' => ['Gurudwara Ceremony', 'Entertainment', 'Food'],
                ],
                'cultural_requirements' => 'Anand Karaj at Gurudwara followed by grand reception. Need full Punjabi entertainment - bhangra, giddha.',
                'additional_info' => 'Large Punjabi families on both sides. Food is extremely important - need best caterers.',
            ],
            [
                'email' => 'reyansh.a@gmail.com',
                'partner_name' => 'Anika Jain',
                'wedding_date' => now()->subMonths(1)->setDay(5),
                'wedding_city' => 'Delhi',
                'wedding_state' => 'Delhi',
                'wedding_venue' => 'ITC Maurya',
                'guest_count' => 450,
                'budget' => 6000000,
                'wedding_type' => 'traditional',
                'planning_status' => 'completed',
                'preferences' => [
                    'style' => 'Classic Elegant',
                    'colors' => ['Pink', 'Gold', 'White'],
                    'priorities' => ['Photography', 'Décor', 'Entertainment'],
                ],
                'cultural_requirements' => 'Jain-Marwari wedding. Vegetarian food only. Both day and evening ceremonies.',
                'additional_info' => 'Wedding completed successfully. Would recommend vendors to others.',
            ],
            [
                'email' => 'kiara.menon@gmail.com',
                'partner_name' => 'Siddharth Pillai',
                'wedding_date' => now()->subMonths(2)->setDay(18),
                'wedding_city' => 'Trivandrum',
                'wedding_state' => 'Kerala',
                'wedding_venue' => 'Uday Samudra Resort',
                'guest_count' => 250,
                'budget' => 2800000,
                'wedding_type' => 'traditional',
                'planning_status' => 'completed',
                'preferences' => [
                    'style' => 'Kerala Traditional',
                    'colors' => ['Cream', 'Gold', 'Green'],
                    'priorities' => ['Ceremony', 'Photography', 'Sadya'],
                ],
                'cultural_requirements' => 'Nair wedding traditions. Thaali tying ceremony at auspicious muhurtham.',
                'additional_info' => 'Beach resort wedding. Completed last month. Very happy with the arrangements.',
            ],
            [
                'email' => 'vihaan.n@yahoo.com',
                'partner_name' => 'Siya Sharma',
                'wedding_date' => now()->addMonths(9)->setDay(12),
                'wedding_city' => 'Shimla',
                'wedding_state' => 'Himachal Pradesh',
                'wedding_venue' => 'Wildflower Hall',
                'guest_count' => 100,
                'budget' => 4000000,
                'wedding_type' => 'destination',
                'planning_status' => 'just_engaged',
                'preferences' => [
                    'style' => 'Mountain Romance',
                    'colors' => ['Burgundy', 'Forest Green', 'Gold'],
                    'priorities' => ['Venue', 'Photography', 'Intimate Experience'],
                ],
                'cultural_requirements' => 'Hindu wedding with pahadi elements. Want snow-capped mountain backdrop.',
                'additional_info' => 'Small, intimate destination wedding. Most guests will stay for 3 nights.',
            ],
        ];

        foreach ($clients as $clientData) {
            $user = User::where('email', $clientData['email'])->first();
            if (!$user) continue;

            unset($clientData['email']);

            Client::create([
                ...$clientData,
                'user_id' => $user->id,
                'phone' => $user->phone,
            ]);
        }

        $this->command->info('✓ Created ' . Client::count() . ' clients with wedding details');
    }
}
