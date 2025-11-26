<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Faq;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoAgencySeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo agencies already exist
        if (Agency::where('slug', Str::slug('Dream Shaadi Planners'))->exists()) {
            $this->command->info('⏭ Demo agencies already seeded, skipping...');
            return;
        }

        $agencies = [
            [
                'email' => 'vikram@dreamshaadi.in',
                'business_name' => 'Dream Shaadi Planners',
                'description' => 'Dream Shaadi Planners is Delhi NCR\'s most trusted wedding planning company with over 15 years of experience in creating unforgettable celebrations. We specialize in grand Indian weddings, intimate ceremonies, and destination events across India and abroad. Our team of 50+ professionals has successfully planned more than 500 weddings, from traditional North Indian celebrations to fusion weddings blending multiple cultures.

We believe every love story deserves a unique celebration. Our end-to-end services include venue selection, vendor management, décor conceptualization, guest coordination, and day-of execution. Whether you dream of a palace wedding in Udaipur or a beachside celebration in Goa, we turn your vision into reality.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => '45, DLF Cyber Hub, Sector 24',
                'postal_code' => '110001',
                'website' => 'https://dreamshaadi.in',
                'phone' => '+91 98111 22333',
                'whatsapp' => '+91 98111 22333',
                'instagram' => 'dreamshaadi',
                'facebook' => 'dreamshaadidel',
                'years_in_business' => 15,
                'specialties' => 'Destination Weddings, Royal Weddings, Celebrity Weddings',
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.8,
                'review_count' => 156,
                'views_count' => 25430,
                'subscription_status' => 'premium',
                'packages' => [
                    ['name' => 'Silver Package', 'price' => 500000, 'description' => 'Perfect for intimate weddings up to 150 guests. Includes venue scouting, vendor coordination, and day-of management.'],
                    ['name' => 'Gold Package', 'price' => 1500000, 'description' => 'Complete wedding planning for up to 400 guests. Includes design & décor, full vendor management, and 3-day coordination.'],
                    ['name' => 'Platinum Package', 'price' => 3500000, 'description' => 'Luxury end-to-end planning for grand weddings. Unlimited guest count, destination options, and dedicated team of 10+ coordinators.'],
                ],
                'faqs' => [
                    ['question' => 'How far in advance should we book?', 'answer' => 'We recommend booking at least 6-8 months in advance for regular weddings and 12 months for destination weddings to ensure availability of top venues and vendors.'],
                    ['question' => 'Do you handle destination weddings?', 'answer' => 'Yes! We have executed weddings in Udaipur, Jaipur, Goa, Kerala, Dubai, Thailand, and several European destinations.'],
                    ['question' => 'What is your payment structure?', 'answer' => 'We typically require 25% advance at booking, 50% one month before the wedding, and the balance 2 weeks before the event.'],
                ],
            ],
            [
                'email' => 'sunita@weddingwala.com',
                'business_name' => 'Wedding Wala Events',
                'description' => 'Wedding Wala Events is a Hyderabad-based wedding planning company known for creating magnificent South Indian and fusion weddings. Founded by Sunita Reddy, a former event manager at Taj Hotels, our company brings hospitality excellence to wedding planning.

We understand the nuances of Telugu, Tamil, and Kannada wedding traditions while seamlessly incorporating modern elements. Our expertise lies in managing multi-day wedding celebrations with 1000+ guests while maintaining the warmth of a family affair. From muhurtham ceremonies to reception nights, we ensure every ritual is performed with perfection.',
                'city' => 'Hyderabad',
                'state' => 'Telangana',
                'address' => '78, Road No. 12, Banjara Hills',
                'postal_code' => '500034',
                'website' => 'https://weddingwala.com',
                'phone' => '+91 98222 33444',
                'whatsapp' => '+91 98222 33444',
                'instagram' => 'weddingwalaevents',
                'facebook' => 'weddingwalachyd',
                'years_in_business' => 12,
                'specialties' => 'South Indian Weddings, Telugu Weddings, Large Scale Events',
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.7,
                'review_count' => 203,
                'views_count' => 18920,
                'subscription_status' => 'premium',
                'packages' => [
                    ['name' => 'Traditional Package', 'price' => 400000, 'description' => 'Comprehensive planning for traditional South Indian weddings with all ceremonies and rituals.'],
                    ['name' => 'Grand Celebration Package', 'price' => 1200000, 'description' => 'Full-service planning for weddings with 500+ guests, including pellikuthuru, muhurtham, and reception.'],
                    ['name' => 'Royal Kalyanam Package', 'price' => 2500000, 'description' => 'Premium planning for prestigious families. Includes multiple venues, celebrity entertainment, and luxury arrangements.'],
                ],
                'faqs' => [
                    ['question' => 'Do you handle all South Indian wedding traditions?', 'answer' => 'Yes, our team is well-versed in Telugu, Tamil, Kannada, and Malayalam wedding customs. We work closely with families to ensure all rituals are observed.'],
                    ['question' => 'Can you manage very large guest lists?', 'answer' => 'Absolutely! We have experience managing weddings with over 2000 guests. Our logistics team ensures smooth operations regardless of scale.'],
                ],
            ],
            [
                'email' => 'arun@royalweddings.in',
                'business_name' => 'Royal Weddings India',
                'description' => 'Royal Weddings India specializes in creating regal wedding experiences in Rajasthan\'s magnificent palace hotels and heritage properties. Based in Jaipur, we have exclusive partnerships with premier venues like City Palace, Umaid Bhawan, and The Oberoi Udaivilas.

Our team combines royal Rajasthani hospitality with world-class event management. We cater to both Indian families seeking traditional grandeur and international clients looking for authentic Indian destination weddings. Every wedding we plan reflects the opulence of Rajasthan while incorporating modern luxury.',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'address' => 'C-Scheme, Ashok Nagar',
                'postal_code' => '302001',
                'website' => 'https://royalweddings.in',
                'phone' => '+91 98333 44555',
                'whatsapp' => '+91 98333 44555',
                'instagram' => 'royalweddingsindia',
                'facebook' => 'royalweddingsjpr',
                'years_in_business' => 18,
                'specialties' => 'Palace Weddings, Heritage Venues, Royal Rajasthani Weddings',
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 89,
                'views_count' => 31240,
                'subscription_status' => 'premium',
                'packages' => [
                    ['name' => 'Heritage Experience', 'price' => 2000000, 'description' => 'Palace wedding experience for up to 200 guests with traditional Rajasthani décor and hospitality.'],
                    ['name' => 'Royal Affair', 'price' => 5000000, 'description' => 'Complete royal wedding with elephant procession, folk entertainment, and accommodation for 300 guests.'],
                    ['name' => 'Maharaja Package', 'price' => 10000000, 'description' => 'Ultimate palace wedding experience. Private venue booking, celebrity performances, and 5-day celebration.'],
                ],
                'faqs' => [
                    ['question' => 'Which palace venues do you work with?', 'answer' => 'We have partnerships with City Palace Jaipur, Umaid Bhawan Jodhpur, Oberoi Udaivilas, Taj Lake Palace, Samode Palace, and many other heritage properties.'],
                    ['question' => 'Can you arrange royal processions?', 'answer' => 'Yes! We can arrange decorated elephants, horse carriages, vintage cars, and traditional band baaja for baraat processions.'],
                ],
            ],
            [
                'email' => 'meera@bandbaajaa.com',
                'business_name' => 'Band Baaja Celebrations',
                'description' => 'Band Baaja Celebrations is Mumbai\'s vibrant wedding planning company known for creating Bollywood-style celebrations. We bring the magic of movie weddings to real life with spectacular choreography, stunning décor, and entertainment that keeps guests dancing all night.

Our specialty is creating high-energy sangeet nights, glamorous receptions, and weddings that are Instagram-worthy from start to finish. We work with the best choreographers, DJs, and performers in the industry to create unforgettable moments. From filmy entry sequences to coordinated family dances, we make sure your wedding is the biggest blockbuster of the year!',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'address' => '201, Linking Road, Bandra West',
                'postal_code' => '400050',
                'website' => 'https://bandbaajaa.com',
                'phone' => '+91 98444 55666',
                'whatsapp' => '+91 98444 55666',
                'instagram' => 'bandbaajaweddings',
                'facebook' => 'bandbaajamumbai',
                'years_in_business' => 8,
                'specialties' => 'Sangeet Planning, Bollywood Weddings, Celebrity-Style Events',
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.6,
                'review_count' => 178,
                'views_count' => 22150,
                'subscription_status' => 'standard',
                'packages' => [
                    ['name' => 'Sangeet Special', 'price' => 300000, 'description' => 'Complete sangeet planning with choreography for 5 performances, DJ, and themed décor.'],
                    ['name' => 'Star Wedding Package', 'price' => 1000000, 'description' => 'Full wedding planning with Bollywood-style elements, professional choreography, and celebrity DJ.'],
                    ['name' => 'Blockbuster Package', 'price' => 2000000, 'description' => 'Premium package with celebrity performers, custom entry sequences, and fireworks finale.'],
                ],
                'faqs' => [
                    ['question' => 'Do you provide choreography services?', 'answer' => 'Yes! We have in-house choreographers who train family members for sangeet performances. We also coordinate surprise flash mobs and couple dances.'],
                    ['question' => 'Can you arrange celebrity performers?', 'answer' => 'We have connections with popular artists, dancers, and DJs. We can arrange performances based on your budget and preferences.'],
                ],
            ],
            [
                'email' => 'deepak@shubhvivah.com',
                'business_name' => 'Shubh Vivah Planners',
                'description' => 'Shubh Vivah Planners is a family-run wedding planning business based in Lucknow, specializing in traditional North Indian weddings with authentic Awadhi charm. For three generations, our family has been creating beautiful wedding celebrations that honor customs while embracing contemporary style.

We are particularly known for our expertise in Brahmin, Kayastha, and other UP-style weddings. Our deep understanding of North Indian rituals, from tilak ceremonies to bidaai, ensures that every tradition is performed perfectly. We also excel at creating intimate home weddings that feel warm and personal.',
                'city' => 'Lucknow',
                'state' => 'Uttar Pradesh',
                'address' => '12, Hazratganj',
                'postal_code' => '226001',
                'website' => 'https://shubhvivah.com',
                'phone' => '+91 98555 66777',
                'whatsapp' => '+91 98555 66777',
                'instagram' => 'shubhvivahplanners',
                'facebook' => 'shubhvivahlko',
                'years_in_business' => 25,
                'specialties' => 'Traditional North Indian Weddings, Awadhi Weddings, Home Weddings',
                'verified' => true,
                'featured' => false,
                'premium' => false,
                'avg_rating' => 4.5,
                'review_count' => 312,
                'views_count' => 15680,
                'subscription_status' => 'standard',
                'packages' => [
                    ['name' => 'Ghar Ki Shaadi', 'price' => 200000, 'description' => 'Intimate home wedding planning for up to 100 guests with traditional décor and catering.'],
                    ['name' => 'Lucknowi Daawat Package', 'price' => 600000, 'description' => 'Complete wedding planning with authentic Awadhi cuisine, traditional mandap, and cultural entertainment.'],
                    ['name' => 'Nawabi Celebration', 'price' => 1200000, 'description' => 'Grand Lucknowi wedding with heritage venue, kebab counters, and qawwali night.'],
                ],
                'faqs' => [
                    ['question' => 'Do you handle small home weddings?', 'answer' => 'Yes, home weddings are our specialty. We have years of experience in creating beautiful celebrations in residential spaces with proper tent arrangements and catering.'],
                    ['question' => 'Can you manage all North Indian wedding rituals?', 'answer' => 'Our team includes experienced pandits and ritual coordinators who ensure every ceremony from roka to vidaai is performed traditionally.'],
                ],
            ],
            [
                'email' => 'kavita@southernweddings.in',
                'business_name' => 'Southern Celebrations',
                'description' => 'Southern Celebrations brings the elegance of Kerala and South Indian weddings to life. Based in Kochi, we specialize in creating serene, beautiful celebrations that blend traditional elements with modern sophistication.

Our expertise covers all aspects of South Indian weddings – from finding the perfect temple or kalyana mandapam to coordinating sadya arrangements and traditional entertainment. We understand the importance of muhurtham timing, proper seating arrangements for ceremonies, and the subtle differences between various South Indian communities\' traditions.',
                'city' => 'Kochi',
                'state' => 'Kerala',
                'address' => 'MG Road, Ernakulam',
                'postal_code' => '682011',
                'website' => 'https://southernweddings.in',
                'phone' => '+91 98666 77888',
                'whatsapp' => '+91 98666 77888',
                'instagram' => 'southerncelebrations',
                'facebook' => 'southernweddingskerala',
                'years_in_business' => 10,
                'specialties' => 'Kerala Weddings, Temple Weddings, Backwater Destination Weddings',
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.7,
                'review_count' => 145,
                'views_count' => 12890,
                'subscription_status' => 'standard',
                'packages' => [
                    ['name' => 'Traditional Kerala Wedding', 'price' => 350000, 'description' => 'Authentic Kerala wedding with kasavu décor, nadaswaram music, and traditional sadya.'],
                    ['name' => 'Backwater Bliss Package', 'price' => 800000, 'description' => 'Destination wedding on Kerala backwaters with houseboat events and resort stay.'],
                    ['name' => 'Premium Kerala Kalyanam', 'price' => 1500000, 'description' => 'Luxury wedding at premium resort with Theyyam performance, classical dance, and ayurvedic spa for guests.'],
                ],
                'faqs' => [
                    ['question' => 'Do you arrange temple weddings?', 'answer' => 'Yes, we coordinate with major temples across Kerala including Guruvayur. We handle all logistics from booking to ceremony arrangements.'],
                    ['question' => 'Can you arrange backwater wedding venues?', 'answer' => 'Absolutely! We have partnerships with luxury resorts in Kumarakom, Alleppey, and Kovalam that offer stunning backwater and beach wedding venues.'],
                ],
            ],
            [
                'email' => 'rohit@destinationido.com',
                'business_name' => 'Destination I Do',
                'description' => 'Destination I Do is India\'s premier destination wedding specialist, offering bespoke wedding experiences at exotic locations across the world. From the beaches of Maldives to the vineyards of Tuscany, we create dream weddings that take your breath away.

Our team includes international logistics experts, multi-lingual coordinators, and design specialists who understand global wedding trends. We handle everything from visa assistance for guests to creating detailed travel itineraries. Every destination wedding we plan is a complete experience – not just an event.',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'address' => '99, Indiranagar 100ft Road',
                'postal_code' => '560038',
                'website' => 'https://destinationido.com',
                'phone' => '+91 98777 88999',
                'whatsapp' => '+91 98777 88999',
                'instagram' => 'destinationido',
                'facebook' => 'destinationidoweddings',
                'years_in_business' => 7,
                'specialties' => 'International Destination Weddings, Beach Weddings, Luxury Resort Weddings',
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.8,
                'review_count' => 67,
                'views_count' => 28450,
                'subscription_status' => 'premium',
                'packages' => [
                    ['name' => 'India Destination', 'price' => 1500000, 'description' => 'Destination wedding within India – Goa, Udaipur, Kerala, or Andamans for up to 100 guests.'],
                    ['name' => 'International Escape', 'price' => 4000000, 'description' => 'International destination wedding in Thailand, Bali, Dubai, or Maldives with full logistics support.'],
                    ['name' => 'Global Luxury Package', 'price' => 8000000, 'description' => 'Ultra-luxury destination wedding in Europe, USA, or Caribbean with private villa booking and exclusive experiences.'],
                ],
                'faqs' => [
                    ['question' => 'How do you handle international logistics?', 'answer' => 'Our team coordinates everything – from group flight bookings to hotel accommodations, visa assistance, and local transportation. We also provide detailed travel guides for guests.'],
                    ['question' => 'What destinations do you recommend?', 'answer' => 'Popular choices include Thailand (Phuket, Koh Samui), Bali, Maldives, Dubai, Mauritius, and European destinations like Italy and Portugal.'],
                ],
            ],
            [
                'email' => 'ananya@eleganceweddings.in',
                'business_name' => 'Elegance Weddings',
                'description' => 'Elegance Weddings crafts sophisticated, minimalist weddings for modern couples who appreciate understated luxury. Based in Pune, we cater to professionals and urban couples who want meaningful celebrations without overwhelming grandeur.

Our design philosophy focuses on creating refined aesthetics with quality over quantity. We specialize in intimate weddings, court marriage celebrations, and modern fusion ceremonies. Every event we plan reflects contemporary sensibilities while respecting tradition. If you dream of a Pinterest-perfect wedding with clean lines, pastel palettes, and meaningful details, we\'re your perfect match.',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'address' => 'Lane 7, Koregaon Park',
                'postal_code' => '411001',
                'website' => 'https://eleganceweddings.in',
                'phone' => '+91 98888 99000',
                'whatsapp' => '+91 98888 99000',
                'instagram' => 'eleganceweddingspune',
                'facebook' => 'eleganceweddingspune',
                'years_in_business' => 5,
                'specialties' => 'Intimate Weddings, Modern Weddings, Minimalist Design',
                'verified' => true,
                'featured' => false,
                'premium' => false,
                'avg_rating' => 4.6,
                'review_count' => 92,
                'views_count' => 9870,
                'subscription_status' => 'standard',
                'packages' => [
                    ['name' => 'Intimate Affair', 'price' => 150000, 'description' => 'Perfect for weddings under 50 guests. Includes venue styling, curated vendor list, and day-of coordination.'],
                    ['name' => 'Modern Romance', 'price' => 400000, 'description' => 'Complete planning for contemporary weddings with designer décor, craft cocktails, and curated music.'],
                    ['name' => 'Elegant Escape', 'price' => 800000, 'description' => 'Boutique destination wedding at vineyard or mountain resort with luxury accommodations.'],
                ],
                'faqs' => [
                    ['question' => 'Do you only do small weddings?', 'answer' => 'While we specialize in intimate weddings (under 150 guests), we also plan mid-sized events. Our focus is on quality and personalization rather than scale.'],
                    ['question' => 'What makes your weddings different?', 'answer' => 'We focus on thoughtful details, sustainable choices, and meaningful experiences rather than grand displays. Every element is carefully curated to reflect the couple\'s personality.'],
                ],
            ],
        ];

        foreach ($agencies as $agencyData) {
            $user = User::where('email', $agencyData['email'])->first();
            if (!$user) continue;

            $packages = $agencyData['packages'] ?? [];
            $faqs = $agencyData['faqs'] ?? [];
            unset($agencyData['email'], $agencyData['packages'], $agencyData['faqs']);

            $agency = Agency::create([
                ...$agencyData,
                'user_id' => $user->id,
                'slug' => Str::slug($agencyData['business_name']),
                'country' => 'India',
                'email' => $user->email,
                'subscription_expires_at' => $agencyData['subscription_status'] === 'premium'
                    ? now()->addYear()
                    : ($agencyData['subscription_status'] === 'standard' ? now()->addMonths(6) : null),
                'working_hours' => [
                    'monday' => ['09:00', '18:00'],
                    'tuesday' => ['09:00', '18:00'],
                    'wednesday' => ['09:00', '18:00'],
                    'thursday' => ['09:00', '18:00'],
                    'friday' => ['09:00', '18:00'],
                    'saturday' => ['10:00', '16:00'],
                    'sunday' => ['closed'],
                ],
            ]);

            // Create packages
            foreach ($packages as $index => $package) {
                Package::create([
                    'packageable_id' => $agency->id,
                    'packageable_type' => Agency::class,
                    'name' => $package['name'],
                    'description' => $package['description'],
                    'price' => $package['price'],
                    'price_unit' => 'per wedding',
                    'is_featured' => $index === 1,
                    'sort_order' => $index + 1,
                    'active' => true,
                ]);
            }

            // Create FAQs
            foreach ($faqs as $index => $faq) {
                Faq::create([
                    'faqable_id' => $agency->id,
                    'faqable_type' => Agency::class,
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'sort_order' => $index + 1,
                    'active' => true,
                ]);
            }
        }

        $this->command->info('✓ Created ' . Agency::count() . ' agencies with packages and FAQs');
    }
}
