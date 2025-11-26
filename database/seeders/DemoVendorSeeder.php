<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Category;
use App\Models\EventType;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoVendorSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo vendors already exist
        if (Vendor::where('slug', Str::slug('Pixel Perfect Studios'))->exists()) {
            $this->command->info('⏭ Demo vendors already seeded, skipping...');
            return;
        }

        $vendors = [
            // ═══════════════════════════════════════════════════════════════════
            // PHOTOGRAPHERS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'arjun@pixelperfect.in',
                'category' => 'Wedding Photographers',
                'business_name' => 'Pixel Perfect Studios',
                'description' => 'Pixel Perfect Studios is Mumbai\'s award-winning wedding photography company, known for capturing emotions in their purest form. Led by Arjun Nair, whose work has been featured in Vogue Wedding and Wedding Sutra, we specialize in candid photography that tells your unique love story.

With a team of 8 photographers and state-of-the-art equipment including drone cameras and cinema-grade video gear, we deliver stunning visuals that you\'ll treasure forever. Our signature style blends photojournalistic approach with fine art aesthetics, creating timeless images with a contemporary edge.',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'address' => '15, Pali Hill Road, Bandra West',
                'min_price' => 150000,
                'max_price' => 500000,
                'years_in_business' => 12,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 234,
                'views_count' => 45670,
                'specialties' => 'Candid Photography, Destination Shoots, Album Design',
                'services' => [
                    ['name' => 'Full Day Photography', 'price' => 75000, 'description' => '8-10 hours coverage with 2 photographers'],
                    ['name' => 'Pre-Wedding Shoot', 'price' => 50000, 'description' => '4-hour session at location of your choice'],
                    ['name' => 'Cinematic Video', 'price' => 100000, 'description' => 'Full wedding film with drone coverage'],
                    ['name' => 'Photo Album', 'price' => 25000, 'description' => '40-page premium hardbound album'],
                ],
                'packages' => [
                    ['name' => 'Essential', 'price' => 150000, 'description' => '2-day coverage, 2 photographers, 1000+ edited photos, online gallery'],
                    ['name' => 'Premium', 'price' => 300000, 'description' => '3-day coverage, 3 photographers, cinematic teaser, premium album'],
                    ['name' => 'Luxury', 'price' => 500000, 'description' => 'Full wedding coverage, destination shoot, documentary film, 2 albums'],
                ],
            ],
            [
                'email' => 'neha@candiddreams.com',
                'category' => 'Wedding Photographers',
                'business_name' => 'Candid Dreams Photography',
                'description' => 'Candid Dreams Photography captures the laughter, tears, and joy of your wedding day with an artistic eye. Founded by Neha Verma, we believe in minimal posing and maximum emotion. Our unobtrusive approach means we\'re always there to capture those fleeting moments – the nervous bride, the proud father, the mischievous cousins.

Based in Delhi, we\'ve photographed weddings across India and have a special love for intimate ceremonies and destination weddings. Every couple gets a dedicated photographer who spends time understanding their story before the wedding.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => '23, Hauz Khas Village',
                'min_price' => 80000,
                'max_price' => 300000,
                'years_in_business' => 8,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.8,
                'review_count' => 156,
                'views_count' => 23450,
                'specialties' => 'Candid Moments, Emotional Portraits, Story-telling',
                'services' => [
                    ['name' => 'Single Day Coverage', 'price' => 60000, 'description' => 'One photographer for full day'],
                    ['name' => 'Couple Portraits', 'price' => 25000, 'description' => '2-hour portrait session'],
                    ['name' => 'Same Day Edit', 'price' => 30000, 'description' => 'Slideshow ready by reception'],
                ],
                'packages' => [
                    ['name' => 'Starter', 'price' => 80000, 'description' => 'Single day, 1 photographer, 500+ photos'],
                    ['name' => 'Complete', 'price' => 180000, 'description' => 'All events coverage, 2 photographers, video teaser'],
                    ['name' => 'Destination', 'price' => 300000, 'description' => 'Travel included, multi-day coverage, full film'],
                ],
            ],
            [
                'email' => 'sid@storiesbysi.com',
                'category' => 'Cinematographers',
                'business_name' => 'Stories by Siddharth',
                'description' => 'Stories by Siddharth creates cinematic wedding films that feel like movies. Using the latest RED and Blackmagic cameras, we bring a filmic quality to wedding videography that sets us apart. Our films have won multiple WeddingWire awards and have been viewed millions of times on YouTube.

We believe every wedding deserves to be remembered like a beautiful film. From the morning preparations to the last dance, we craft narratives that capture not just events, but emotions. Our post-production includes color grading, licensed music, and professional editing.',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'address' => '45, 100 Feet Road, Indiranagar',
                'min_price' => 200000,
                'max_price' => 800000,
                'years_in_business' => 10,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 89,
                'views_count' => 34560,
                'specialties' => 'Cinematic Films, Drone Coverage, Music Videos',
                'services' => [
                    ['name' => 'Wedding Teaser', 'price' => 50000, 'description' => '3-5 minute highlight video'],
                    ['name' => 'Full Wedding Film', 'price' => 150000, 'description' => '30-60 minute documentary'],
                    ['name' => 'Same Day Edit', 'price' => 40000, 'description' => '5-minute edit for reception screening'],
                ],
                'packages' => [
                    ['name' => 'Silver', 'price' => 200000, 'description' => '2-day shoot, teaser + 20-min film'],
                    ['name' => 'Gold', 'price' => 450000, 'description' => 'Multi-day, full documentary, drone coverage'],
                    ['name' => 'Platinum', 'price' => 800000, 'description' => 'Premium equipment, 3 videographers, feature film'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // CATERERS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'ramesh@royalcaterers.in',
                'category' => 'Wedding Caterers',
                'business_name' => 'Royal Caterers Delhi',
                'description' => 'Royal Caterers has been serving North India\'s most prestigious weddings for over 30 years. Our expertise lies in grand-scale catering for 1000+ guests without compromising on taste or presentation. We\'ve served at celebrity weddings, diplomatic events, and royal family celebrations.

Our menu spans from traditional Mughlai and Punjabi cuisines to contemporary Indian fusion. With 200+ trained staff and 15 executive chefs, we ensure consistent quality across all your wedding functions. We also offer live cooking stations, interactive food experiences, and themed food décor.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => 'Industrial Area, Okhla Phase 2',
                'min_price' => 1200,
                'max_price' => 4500,
                'price_unit' => 'per plate',
                'years_in_business' => 32,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.7,
                'review_count' => 445,
                'views_count' => 28900,
                'specialties' => 'Large Scale Weddings, Mughlai Cuisine, Live Counters',
                'services' => [
                    ['name' => 'Vegetarian Menu', 'price' => 1200, 'price_unit' => 'per plate', 'description' => '12-course veg meal with starters, mains, and desserts'],
                    ['name' => 'Non-Veg Premium', 'price' => 1800, 'price_unit' => 'per plate', 'description' => 'Full non-veg spread with kebabs and curries'],
                    ['name' => 'Live Chaat Counter', 'price' => 50000, 'description' => 'Interactive chaat station with chef'],
                    ['name' => 'Mithai Station', 'price' => 35000, 'description' => 'Traditional Indian sweets display'],
                ],
                'packages' => [
                    ['name' => 'Classic Wedding Package', 'price' => 1400, 'price_unit' => 'per plate', 'description' => '15-item menu with basic setup'],
                    ['name' => 'Premium Package', 'price' => 2500, 'price_unit' => 'per plate', 'description' => '25-item menu, live counters, premium setup'],
                    ['name' => 'Royal Package', 'price' => 4500, 'price_unit' => 'per plate', 'description' => 'Unlimited menu, butler service, themed décor'],
                ],
            ],
            [
                'email' => 'lakshmi@swaadcatering.com',
                'category' => 'Multi-Cuisine Caterers',
                'business_name' => 'Swaad Catering Services',
                'description' => 'Swaad Catering brings the authentic flavors of South India to your wedding celebrations. Based in Chennai, we specialize in traditional Tamil Brahmin weddings, elaborate sadyas, and Chettinad non-vegetarian feasts. Our team includes experienced cooks who have trained at leading temples and traditional households.

We understand the importance of getting wedding food right – from the elai sappadu served on banana leaves to the elaborate reception dinner. We also offer fusion options for couples wanting to blend traditions, with live dosa stations, filter coffee bars, and contemporary presentations of classic dishes.',
                'city' => 'Chennai',
                'state' => 'Tamil Nadu',
                'address' => 'Anna Nagar West',
                'min_price' => 800,
                'max_price' => 2500,
                'price_unit' => 'per plate',
                'years_in_business' => 18,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.8,
                'review_count' => 267,
                'views_count' => 19450,
                'specialties' => 'South Indian Weddings, Brahmin Catering, Chettinad Cuisine',
                'services' => [
                    ['name' => 'Traditional Elai Sappadu', 'price' => 800, 'price_unit' => 'per plate', 'description' => 'Authentic banana leaf meal with 20+ items'],
                    ['name' => 'Kerala Sadya', 'price' => 900, 'price_unit' => 'per plate', 'description' => '24-item traditional sadya'],
                    ['name' => 'Chettinad Non-Veg', 'price' => 1200, 'price_unit' => 'per plate', 'description' => 'Spicy Chettinad chicken and mutton'],
                    ['name' => 'Filter Coffee Service', 'price' => 15000, 'description' => 'Continuous filter coffee station'],
                ],
                'packages' => [
                    ['name' => 'Traditional Wedding', 'price' => 900, 'price_unit' => 'per plate', 'description' => 'Complete traditional meal service'],
                    ['name' => 'Grand Reception', 'price' => 1600, 'price_unit' => 'per plate', 'description' => 'Multi-cuisine spread with live counters'],
                    ['name' => 'Premium Celebration', 'price' => 2500, 'price_unit' => 'per plate', 'description' => 'Butler service, premium ingredients, custom menu'],
                ],
            ],
            [
                'email' => 'khan@mughalcuisine.in',
                'category' => 'Multi-Cuisine Caterers',
                'business_name' => 'Khan\'s Mughal Cuisine',
                'description' => 'Khan\'s Mughal Cuisine has been the gold standard for Mughlai and Awadhi wedding catering in Lucknow for three generations. Our recipes have been passed down from the royal kitchens of Awadh, and our master chefs include several who trained under legendary ustads.

We are renowned for our kebabs – from melt-in-mouth galouti to crispy seekh – and our rich, aromatic biryanis. For Muslim weddings, we offer complete walima catering with traditional hospitality. Our dawats have served everyone from business tycoons to film stars visiting Lucknow.',
                'city' => 'Lucknow',
                'state' => 'Uttar Pradesh',
                'address' => 'Aminabad Market',
                'min_price' => 1000,
                'max_price' => 3500,
                'price_unit' => 'per plate',
                'years_in_business' => 45,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 389,
                'views_count' => 21340,
                'specialties' => 'Awadhi Cuisine, Kebabs, Biryanis, Walima Catering',
                'services' => [
                    ['name' => 'Lucknowi Veg Dawat', 'price' => 1000, 'price_unit' => 'per plate', 'description' => 'Traditional vegetarian feast'],
                    ['name' => 'Non-Veg Dawat', 'price' => 1500, 'price_unit' => 'per plate', 'description' => 'Full kebab and curry spread'],
                    ['name' => 'Live Kebab Counter', 'price' => 45000, 'description' => '5 varieties of fresh kebabs'],
                    ['name' => 'Biryani Station', 'price' => 35000, 'description' => 'Lucknowi dum biryani service'],
                ],
                'packages' => [
                    ['name' => 'Daawat Package', 'price' => 1200, 'price_unit' => 'per plate', 'description' => 'Traditional wedding feast'],
                    ['name' => 'Nawabi Package', 'price' => 2200, 'price_unit' => 'per plate', 'description' => 'Premium spread with specialty items'],
                    ['name' => 'Shahi Package', 'price' => 3500, 'price_unit' => 'per plate', 'description' => 'Royal feast with rare delicacies'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // DECORATORS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'pooja@floralaffairs.in',
                'category' => 'Wedding Decorators',
                'business_name' => 'Floral Affairs',
                'description' => 'Floral Affairs transforms wedding venues into dreamy wonderlands using the finest flowers, fabrics, and innovative design. Founded by Pooja Mehta, a graduate of the London School of Floristry, we bring international design sensibilities to Indian weddings.

We source fresh flowers daily from markets in Bangalore, Ooty, and even import specialty blooms from Thailand and Netherlands for premium events. From cascading orchid chandeliers to rose-covered mandaps, our floral installations create Instagram-worthy moments at every corner. We also specialize in sustainable décor using potted plants and eco-friendly materials.',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'address' => '89, Bandra Kurla Complex',
                'min_price' => 300000,
                'max_price' => 2500000,
                'years_in_business' => 9,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.8,
                'review_count' => 167,
                'views_count' => 32100,
                'specialties' => 'Floral Design, Luxury Décor, Sustainable Weddings',
                'services' => [
                    ['name' => 'Mandap Décor', 'price' => 150000, 'description' => 'Complete mandap setup with fresh flowers'],
                    ['name' => 'Stage Design', 'price' => 100000, 'description' => 'Reception stage with backdrop'],
                    ['name' => 'Table Centerpieces', 'price' => 5000, 'price_unit' => 'per table', 'description' => 'Fresh floral arrangements'],
                    ['name' => 'Entrance Décor', 'price' => 75000, 'description' => 'Grand entrance archway'],
                ],
                'packages' => [
                    ['name' => 'Elegant', 'price' => 300000, 'description' => 'Essential décor for one function'],
                    ['name' => 'Luxe', 'price' => 800000, 'description' => 'Premium décor for all functions'],
                    ['name' => 'Bespoke', 'price' => 2500000, 'description' => 'Custom installation with imported flowers'],
                ],
            ],
            [
                'email' => 'rakesh@royaldecor.com',
                'category' => 'Mandap Decoration',
                'business_name' => 'Royal Décor & Events',
                'description' => 'Royal Décor & Events is Delhi\'s leading wedding decoration company, known for creating opulent setups that leave guests speechless. With over 200 weddings annually, we have the experience and resources to handle grand celebrations of any scale.

Our design philosophy combines traditional Indian grandeur with contemporary elegance. We specialize in creating stunning mandaps – from classic temple-style structures with marigold and jasmine to modern geometric designs with orchids and roses. Our inventory includes premium furniture, chandeliers, stage props, and lighting equipment for complete venue transformation.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => 'Kirti Nagar, Wedding Hub',
                'min_price' => 200000,
                'max_price' => 3000000,
                'years_in_business' => 22,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.7,
                'review_count' => 312,
                'views_count' => 28760,
                'specialties' => 'Grand Weddings, Traditional Mandaps, Complete Venue Setup',
                'services' => [
                    ['name' => 'Traditional Mandap', 'price' => 175000, 'description' => 'Classic mandap with fresh flowers'],
                    ['name' => 'Modern Stage', 'price' => 125000, 'description' => 'Contemporary reception backdrop'],
                    ['name' => 'Full Venue Draping', 'price' => 200000, 'description' => 'Complete tent and ceiling décor'],
                    ['name' => 'Lighting Package', 'price' => 150000, 'description' => 'Chandeliers and ambient lighting'],
                ],
                'packages' => [
                    ['name' => 'Classic Wedding', 'price' => 400000, 'description' => 'Mandap + stage + basic venue décor'],
                    ['name' => 'Premium Wedding', 'price' => 1200000, 'description' => 'All events décor with premium elements'],
                    ['name' => 'Royal Wedding', 'price' => 3000000, 'description' => 'Destination-level setup with complete transformation'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // MAKEUP ARTISTS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'simran@bridalbysim.com',
                'category' => 'Bridal Makeup Artists',
                'business_name' => 'Bridal by Simran',
                'description' => 'Bridal by Simran is one of Delhi\'s most sought-after bridal makeup artists, known for creating looks that enhance natural beauty while ensuring you look stunning in photos and videos. Simran Kaur trained at the London College of Makeup and has worked with top fashion photographers and Bollywood productions.

Every bride gets a personal consultation and trial session to perfect their wedding look. We specialize in HD airbrush makeup, which lasts 12+ hours and photographs beautifully. From traditional Indian brides to modern minimalist looks, we customize every makeover to match your outfit, skin tone, and personality.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => 'Defence Colony',
                'min_price' => 35000,
                'max_price' => 150000,
                'years_in_business' => 11,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 423,
                'views_count' => 56780,
                'specialties' => 'HD Airbrush, Natural Glam, South Asian Brides',
                'services' => [
                    ['name' => 'Bridal Trial', 'price' => 8000, 'description' => 'Pre-wedding consultation and trial'],
                    ['name' => 'Bridal Makeup', 'price' => 35000, 'description' => 'Wedding day makeup with HD airbrush'],
                    ['name' => 'Engagement Look', 'price' => 25000, 'description' => 'Complete makeup and hairstyling'],
                    ['name' => 'Family Makeup', 'price' => 12000, 'price_unit' => 'per person', 'description' => 'For mother of bride/groom'],
                ],
                'packages' => [
                    ['name' => 'Essential Bride', 'price' => 45000, 'description' => 'Trial + wedding day makeup'],
                    ['name' => 'Complete Bride', 'price' => 85000, 'description' => 'All functions – mehndi to reception'],
                    ['name' => 'VIP Package', 'price' => 150000, 'description' => 'Bride + 5 family members, all events'],
                ],
            ],
            [
                'email' => 'anjali@glamourstudio.in',
                'category' => 'Bridal Makeup Artists',
                'business_name' => 'Glamour Studio by Anjali',
                'description' => 'Glamour Studio by Anjali brings Bollywood-style glamour to brides across Maharashtra. Based in Pune, Anjali Deshmukh has been making brides camera-ready for over 15 years, with a portfolio that includes actresses and socialites. Her signature style is dramatic yet elegant – perfect for Indian weddings.

We use only premium international brands (MAC, Bobbi Brown, NARS) and are experts in working with all Indian skin tones. Our studio in Koregaon Park offers a luxurious bridal experience with private suites for getting ready. We also travel for destination weddings.',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'address' => 'Lane 6, Koregaon Park',
                'min_price' => 25000,
                'max_price' => 100000,
                'years_in_business' => 15,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.7,
                'review_count' => 289,
                'views_count' => 34560,
                'specialties' => 'Dramatic Looks, Skin Prep, Long-lasting Makeup',
                'services' => [
                    ['name' => 'Bridal Makeup', 'price' => 25000, 'description' => 'Complete bridal look with hairstyling'],
                    ['name' => 'Party Makeup', 'price' => 15000, 'description' => 'Sangeet or reception ready'],
                    ['name' => 'Draping Service', 'price' => 5000, 'description' => 'Saree or dupatta draping'],
                ],
                'packages' => [
                    ['name' => 'Basic Bride', 'price' => 35000, 'description' => 'Wedding day complete look'],
                    ['name' => 'Full Package', 'price' => 75000, 'description' => 'All wedding functions covered'],
                    ['name' => 'Premium Package', 'price' => 100000, 'description' => 'Bride + 3 family members, all events'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // MEHNDI ARTISTS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'sarita@mehndibysarita.com',
                'category' => 'Mehndi Artists',
                'business_name' => 'Mehndi by Sarita',
                'description' => 'Mehndi by Sarita is Rajasthan\'s most celebrated mehndi artist, famous for intricate Rajasthani designs that tell beautiful stories. With over 20 years of experience, Sarita Choudhary has applied mehndi at royal weddings, celebrity celebrations, and thousands of happy brides.

Our signature style features detailed portraits, personalized motifs including hidden names and love stories, and designs that wrap beautifully around the hands and feet. We use 100% natural henna cones that leave rich, dark stains lasting 2-3 weeks. We also offer contemporary Arabic and Indo-Western designs for modern brides.',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'address' => 'MI Road, Near Albert Hall',
                'min_price' => 15000,
                'max_price' => 75000,
                'years_in_business' => 22,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 567,
                'views_count' => 43210,
                'specialties' => 'Rajasthani Design, Portrait Mehndi, Bridal Special',
                'services' => [
                    ['name' => 'Bridal Mehndi', 'price' => 15000, 'description' => 'Full hands and feet with portrait'],
                    ['name' => 'Family Mehndi', 'price' => 2000, 'price_unit' => 'per person', 'description' => 'Single-side hand design'],
                    ['name' => 'Guest Mehndi', 'price' => 500, 'price_unit' => 'per person', 'description' => 'Simple designs for guests'],
                ],
                'packages' => [
                    ['name' => 'Bride Only', 'price' => 25000, 'description' => 'Elaborate bridal mehndi with portrait'],
                    ['name' => 'Family Package', 'price' => 50000, 'description' => 'Bride + 15 family members'],
                    ['name' => 'Complete Wedding', 'price' => 75000, 'description' => 'Bride, family, and 50 guests'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // DJ & ENTERTAINMENT
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'rahul@djrahulofficial.com',
                'category' => 'DJs',
                'business_name' => 'DJ Rahul Official',
                'description' => 'DJ Rahul is one of India\'s top wedding DJs, known for reading crowds perfectly and keeping dance floors packed all night. With over 500 weddings under his belt, he brings the energy that makes Indian wedding celebrations legendary. From Bollywood classics to Punjabi beats, international hits to regional favorites, he crafts the perfect playlist for every moment.

Our professional setup includes premium sound systems (JBL, Bose), LED walls, stage lighting, and special effects. We also offer MC services to keep your events flowing smoothly. Whether it\'s an intimate sangeet or a 1000-guest reception, we scale our setup to fit perfectly.',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'address' => 'Andheri West',
                'min_price' => 50000,
                'max_price' => 300000,
                'years_in_business' => 14,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.8,
                'review_count' => 345,
                'views_count' => 38900,
                'specialties' => 'Wedding DJ, Bollywood Music, High Energy Sets',
                'services' => [
                    ['name' => 'DJ Service', 'price' => 50000, 'description' => '4-hour set with basic sound'],
                    ['name' => 'Premium Setup', 'price' => 100000, 'description' => 'Full night with LED wall'],
                    ['name' => 'MC Service', 'price' => 25000, 'description' => 'Professional anchor for events'],
                ],
                'packages' => [
                    ['name' => 'Essential', 'price' => 75000, 'description' => 'DJ + sound for one event'],
                    ['name' => 'Complete Entertainment', 'price' => 180000, 'description' => 'All functions with premium setup'],
                    ['name' => 'Ultimate Package', 'price' => 300000, 'description' => 'DJ + MC + LED wall + special effects'],
                ],
            ],
            [
                'email' => 'amit@rhythmband.com',
                'category' => 'Live Bands',
                'business_name' => 'Rhythm Live Band',
                'description' => 'Rhythm Live Band brings the magic of live music to your wedding celebrations. Led by Amit Trivedi (not to be confused with the famous composer!), our 10-piece band performs everything from romantic Bollywood melodies to high-energy Punjabi songs that get everyone dancing.

We specialize in sangeet performances, cocktail music, and romantic wedding entry songs. Our versatile musicians can seamlessly switch between Hindi, English, Tamil, and Punjabi songs. We also offer instrumental music for ceremonies and soft jazz for sophisticated cocktail hours.',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'address' => 'Mayur Vihar Phase 2',
                'min_price' => 80000,
                'max_price' => 250000,
                'years_in_business' => 12,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.7,
                'review_count' => 156,
                'views_count' => 21340,
                'specialties' => 'Live Performances, Bollywood Songs, Multi-language',
                'services' => [
                    ['name' => '2-Hour Set', 'price' => 80000, 'description' => '5-piece band performance'],
                    ['name' => '4-Hour Set', 'price' => 140000, 'description' => 'Full band with breaks'],
                    ['name' => 'Acoustic Set', 'price' => 50000, 'description' => 'Intimate 3-piece performance'],
                ],
                'packages' => [
                    ['name' => 'Sangeet Special', 'price' => 100000, 'description' => '3-hour high-energy performance'],
                    ['name' => 'Wedding Package', 'price' => 200000, 'description' => 'Sangeet + reception performances'],
                    ['name' => 'Complete Coverage', 'price' => 250000, 'description' => 'All events with varied setups'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // VENUES
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'suresh@palaceresort.in',
                'category' => 'Heritage Properties',
                'business_name' => 'Rambagh Palace Resort',
                'description' => 'Rambagh Palace Resort is Jaipur\'s most prestigious wedding venue, a former royal residence now offering fairytale wedding experiences. Set amidst 47 acres of Mughal gardens, the palace features stunning architecture, royal suites, and multiple event spaces that accommodate from intimate gatherings to grand celebrations of 1500+ guests.

Our experienced wedding team has hosted over 200 weddings, including several high-profile celebrity and business family celebrations. The palace offers dedicated spaces for every wedding function – from the poolside mehndi to the grand durbar hall reception. Royal treatment includes elephant décor, palace staff in traditional attire, and heritage car services.',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'address' => 'Bhawani Singh Road',
                'min_price' => 1500000,
                'max_price' => 5000000,
                'price_unit' => 'per day',
                'years_in_business' => 35,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 78,
                'views_count' => 67890,
                'specialties' => 'Palace Weddings, Royal Experience, Heritage Venue',
                'services' => [
                    ['name' => 'Durbar Hall', 'price' => 800000, 'price_unit' => 'per day', 'description' => 'Grand hall for 500 guests'],
                    ['name' => 'Garden Lawn', 'price' => 600000, 'price_unit' => 'per day', 'description' => 'Open-air venue for 1000 guests'],
                    ['name' => 'Royal Suites', 'price' => 50000, 'price_unit' => 'per night', 'description' => 'Luxury accommodation'],
                    ['name' => 'Elephant Service', 'price' => 75000, 'description' => 'Decorated elephant for baraat'],
                ],
                'packages' => [
                    ['name' => '2-Day Wedding', 'price' => 3500000, 'description' => 'Exclusive venue, 2 functions, 50 rooms'],
                    ['name' => '3-Day Celebration', 'price' => 6000000, 'description' => 'Full palace, all functions, 75 rooms'],
                    ['name' => 'Royal Wedding', 'price' => 12000000, 'description' => '5-day exclusive booking, complete services'],
                ],
            ],
            [
                'email' => 'prakash@grandballroom.com',
                'category' => 'Banquet Halls',
                'business_name' => 'The Grand Ballroom',
                'description' => 'The Grand Ballroom is Delhi\'s premier indoor wedding venue, featuring a stunning 20,000 sq ft pillarless hall with 30-foot ceilings and crystal chandeliers. Located in the heart of South Delhi, we offer the perfect blend of accessibility and grandeur.

Our state-of-the-art facility includes built-in AV systems, climate control, flexible lighting, and attached preparation rooms. We can accommodate 800 guests for sit-down dinners or 1200 for cocktail receptions. Our in-house design team works with your decorator to create the perfect ambiance. Ample parking and valet services ensure guest convenience.',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'address' => 'Greater Kailash 2',
                'min_price' => 400000,
                'max_price' => 1200000,
                'price_unit' => 'per day',
                'years_in_business' => 15,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.6,
                'review_count' => 234,
                'views_count' => 45670,
                'specialties' => 'Indoor Weddings, Climate Controlled, Central Location',
                'services' => [
                    ['name' => 'Main Ballroom', 'price' => 400000, 'price_unit' => 'per day', 'description' => 'Full hall for up to 800 guests'],
                    ['name' => 'Half Hall', 'price' => 250000, 'price_unit' => 'per day', 'description' => 'Partitioned space for 400 guests'],
                    ['name' => 'Terrace Garden', 'price' => 150000, 'price_unit' => 'per day', 'description' => 'Open area for pre-function'],
                    ['name' => 'Bridal Suite', 'price' => 25000, 'description' => 'Private room for bride preparation'],
                ],
                'packages' => [
                    ['name' => 'Day Wedding', 'price' => 500000, 'description' => 'Full hall, morning to evening'],
                    ['name' => 'Evening Reception', 'price' => 650000, 'description' => 'Full hall, evening to midnight'],
                    ['name' => 'Complete Wedding', 'price' => 1200000, 'description' => 'Two functions on same/consecutive days'],
                ],
            ],
            [
                'email' => 'harish@beachsideresort.in',
                'category' => 'Beach & Garden Venues',
                'business_name' => 'Beachside Resort Goa',
                'description' => 'Beachside Resort offers stunning beachfront wedding venues in South Goa, perfect for couples dreaming of a destination wedding with sand between their toes. Our 5-star property features pristine private beach access, tropical gardens, and multiple venue spaces overlooking the Arabian Sea.

We specialize in intimate beach weddings (up to 200 guests) as well as larger celebrations using our lawn and ballroom. Our wedding coordinator helps with everything from travel logistics to local vendor coordination. Many couples choose us for multi-day celebrations combining wedding traditions with a Goa vacation for guests.',
                'city' => 'South Goa',
                'state' => 'Goa',
                'address' => 'Cavelossim Beach Road',
                'min_price' => 800000,
                'max_price' => 3000000,
                'price_unit' => 'per day',
                'years_in_business' => 12,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.8,
                'review_count' => 145,
                'views_count' => 56780,
                'specialties' => 'Beach Weddings, Destination Weddings, Resort Venue',
                'services' => [
                    ['name' => 'Beach Ceremony', 'price' => 400000, 'description' => 'Private beach setup for 100 guests'],
                    ['name' => 'Garden Reception', 'price' => 500000, 'description' => 'Lawn space for 300 guests'],
                    ['name' => 'Pool Party', 'price' => 200000, 'description' => 'Poolside event for mehndi/haldi'],
                    ['name' => 'Guest Rooms', 'price' => 8000, 'price_unit' => 'per night', 'description' => 'Deluxe sea-view rooms'],
                ],
                'packages' => [
                    ['name' => 'Intimate Beach Wedding', 'price' => 1500000, 'description' => 'Beach ceremony + dinner, 50 guests, 2 nights'],
                    ['name' => '3-Day Celebration', 'price' => 3500000, 'description' => 'All events, 100 guests, 40 rooms'],
                    ['name' => 'Grand Destination', 'price' => 6000000, 'description' => '5-day exclusive booking, 200 guests, 80 rooms'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // CHOREOGRAPHERS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'parul@sangeetbypaul.in',
                'category' => 'Sangeet Choreographers',
                'business_name' => 'Sangeet by Parul',
                'description' => 'Sangeet by Parul choreographs unforgettable sangeet performances that have families dancing with joy. We specialize in creating fun, easy-to-learn routines that make everyone – from kids to grandparents – look great on stage. No dance experience needed!

Our choreography includes everything from couple dances and group performances to surprise flash mobs and emotional parent-child numbers. We teach via video tutorials for outstation family members and offer intensive weekend workshops. We\'ve choreographed sangeets for 400+ weddings and several celebrity celebrations.',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'address' => 'Vasant Kunj',
                'min_price' => 30000,
                'max_price' => 150000,
                'years_in_business' => 8,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.8,
                'review_count' => 234,
                'views_count' => 28900,
                'specialties' => 'Family Performances, Couple Dance, Flash Mobs',
                'services' => [
                    ['name' => 'Couple Dance', 'price' => 30000, 'description' => 'First dance choreography, 4 sessions'],
                    ['name' => 'Family Performance', 'price' => 25000, 'price_unit' => 'per group', 'description' => 'Group of 5-8 people, 4 sessions'],
                    ['name' => 'Flash Mob', 'price' => 50000, 'description' => 'Surprise performance, 6 sessions'],
                ],
                'packages' => [
                    ['name' => 'Basic', 'price' => 50000, 'description' => 'Couple + 2 family performances'],
                    ['name' => 'Standard', 'price' => 100000, 'description' => 'Couple + 5 performances, day coordination'],
                    ['name' => 'Premium', 'price' => 150000, 'description' => 'Unlimited performances, full sangeet direction'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // INVITATION DESIGNERS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'kunal@cardsbykun.com',
                'category' => 'Wedding Cards',
                'business_name' => 'Cards by Kunal',
                'description' => 'Cards by Kunal creates bespoke wedding invitations that set the tone for your celebration. From traditional scroll invitations to modern minimalist designs, we craft cards that become keepsakes. Our in-house design team includes calligraphers, illustrators, and print specialists.

We offer a wide range of materials including handmade paper, velvet, acrylic, and wood. Our specialty is creating custom illustrated invitations featuring the couple\'s love story or cultural elements. We also provide complete wedding stationery – save the dates, menus, seating cards, and thank you notes.',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'address' => 'Johari Bazaar',
                'min_price' => 200,
                'max_price' => 2000,
                'price_unit' => 'per card',
                'years_in_business' => 18,
                'verified' => true,
                'featured' => true,
                'premium' => false,
                'avg_rating' => 4.7,
                'review_count' => 456,
                'views_count' => 23450,
                'specialties' => 'Custom Design, Traditional Cards, Luxury Invitations',
                'services' => [
                    ['name' => 'Standard Cards', 'price' => 200, 'price_unit' => 'per card', 'description' => 'Single insert, quality paper'],
                    ['name' => 'Premium Cards', 'price' => 500, 'price_unit' => 'per card', 'description' => 'Multi-insert, specialty paper'],
                    ['name' => 'Luxury Boxes', 'price' => 1500, 'price_unit' => 'per box', 'description' => 'Box invite with sweet/dry fruit'],
                ],
                'packages' => [
                    ['name' => '100 Cards', 'price' => 25000, 'description' => 'Standard design, 100 pieces'],
                    ['name' => '200 Premium', 'price' => 80000, 'description' => 'Custom design, 200 premium cards'],
                    ['name' => 'Complete Stationery', 'price' => 150000, 'description' => 'Cards + save date + menu + seating'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // PANDITS
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'shastri@vedicweddings.in',
                'category' => 'Wedding Pandits',
                'business_name' => 'Vedic Weddings by Pt. Shastri',
                'description' => 'Pandit Ramakrishna Shastri conducts authentic Vedic wedding ceremonies with deep knowledge of Sanskrit scriptures and rituals. With 35 years of experience, he has performed over 3,000 weddings across India and abroad, for families seeking traditional ceremonies conducted with proper mantras and explanations.

What sets us apart is our approach of explaining each ritual in both Sanskrit and English/Hindi, so the couple and guests understand the beautiful meaning behind every step. We adapt ceremony length based on your needs while maintaining ritual authenticity. We also help with muhurat selection, havan arrangements, and complete ceremony coordination.',
                'city' => 'Varanasi',
                'state' => 'Uttar Pradesh',
                'address' => 'Assi Ghat',
                'min_price' => 21000,
                'max_price' => 101000,
                'years_in_business' => 35,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.9,
                'review_count' => 567,
                'views_count' => 34560,
                'specialties' => 'Traditional Weddings, Sanskrit Scholar, Multi-regional',
                'services' => [
                    ['name' => 'Standard Ceremony', 'price' => 21000, 'description' => '2-hour wedding ceremony'],
                    ['name' => 'Full Day Services', 'price' => 51000, 'description' => 'Haldi to vidaai, all rituals'],
                    ['name' => 'Travel & Stay', 'price' => 25000, 'description' => 'Outstation travel charges'],
                ],
                'packages' => [
                    ['name' => 'Essential Ceremony', 'price' => 25000, 'description' => 'Core wedding rituals with explanation'],
                    ['name' => 'Complete Wedding', 'price' => 65000, 'description' => 'All ceremonies from ganesh puja to vidaai'],
                    ['name' => 'Premium Package', 'price' => 101000, 'description' => 'Multi-day rituals, destination travel included'],
                ],
            ],

            // ═══════════════════════════════════════════════════════════════════
            // TRANSPORTATION
            // ═══════════════════════════════════════════════════════════════════
            [
                'email' => 'rajiv@luxurycars.in',
                'category' => 'Luxury Cars',
                'business_name' => 'Luxury Wedding Cars',
                'description' => 'Luxury Wedding Cars offers the finest wedding transportation in North India, featuring an impressive fleet of vehicles for grand entries and VIP travel. Our collection includes Rolls Royce Phantom, Bentley Continental, Mercedes S-Class, Range Rover, and decorated vintage cars.

Every wedding car comes with a professional chauffeur in formal attire, fresh flower decoration, and red carpet service. We understand the importance of timing in Indian weddings and guarantee punctuality. Our coordination team works with your wedding planner to ensure smooth logistics for baraat processions and VIP movement.',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'address' => 'Connaught Place',
                'min_price' => 25000,
                'max_price' => 150000,
                'price_unit' => 'per day',
                'years_in_business' => 20,
                'verified' => true,
                'featured' => true,
                'premium' => true,
                'avg_rating' => 4.7,
                'review_count' => 234,
                'views_count' => 19870,
                'specialties' => 'Luxury Fleet, Baraat Cars, VIP Service',
                'services' => [
                    ['name' => 'Mercedes S-Class', 'price' => 25000, 'price_unit' => 'per day', 'description' => 'Chauffeur-driven luxury sedan'],
                    ['name' => 'Range Rover', 'price' => 35000, 'price_unit' => 'per day', 'description' => 'Premium SUV with decoration'],
                    ['name' => 'Rolls Royce', 'price' => 85000, 'price_unit' => 'per day', 'description' => 'Ultimate luxury for bride/groom'],
                    ['name' => 'Vintage Car', 'price' => 45000, 'price_unit' => 'per day', 'description' => 'Classic car for photos'],
                ],
                'packages' => [
                    ['name' => 'Groom Package', 'price' => 40000, 'description' => 'Mercedes for baraat + vidaai'],
                    ['name' => 'VIP Package', 'price' => 100000, 'description' => 'Rolls Royce + 2 Mercedes escort'],
                    ['name' => 'Complete Fleet', 'price' => 200000, 'description' => '5 luxury cars for entire wedding'],
                ],
            ],
        ];

        // Get all categories for lookup
        $categories = Category::pluck('id', 'name');
        $eventTypes = EventType::pluck('id', 'name');

        // Get agencies for vendor association
        $agencies = Agency::with('user')->get();

        foreach ($vendors as $vendorData) {
            $user = User::where('email', $vendorData['email'])->first();
            if (!$user) continue;

            $categoryId = $categories[$vendorData['category']] ?? null;
            if (!$categoryId) continue;

            $services = $vendorData['services'] ?? [];
            $packages = $vendorData['packages'] ?? [];
            unset($vendorData['email'], $vendorData['category'], $vendorData['services'], $vendorData['packages']);

            $vendor = Vendor::create([
                ...$vendorData,
                'user_id' => $user->id,
                'category_id' => $categoryId,
                'slug' => Str::slug($vendorData['business_name']),
                'country' => 'India',
                'email' => $user->email,
                'phone' => $user->phone,
                'price_unit' => $vendorData['price_unit'] ?? 'per event',
                'subscription_status' => $vendorData['premium'] ? 'premium' : ($vendorData['featured'] ? 'standard' : 'free'),
                'subscription_expires_at' => $vendorData['premium']
                    ? now()->addYear()
                    : ($vendorData['featured'] ? now()->addMonths(6) : null),
                'working_hours' => [
                    'monday' => ['09:00', '19:00'],
                    'tuesday' => ['09:00', '19:00'],
                    'wednesday' => ['09:00', '19:00'],
                    'thursday' => ['09:00', '19:00'],
                    'friday' => ['09:00', '19:00'],
                    'saturday' => ['09:00', '21:00'],
                    'sunday' => ['10:00', '18:00'],
                ],
            ]);

            // Create services
            foreach ($services as $index => $service) {
                Service::create([
                    'vendor_id' => $vendor->id,
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'price_unit' => $service['price_unit'] ?? 'per service',
                    'is_featured' => $index === 0,
                    'sort_order' => $index + 1,
                    'available' => true,
                ]);
            }

            // Create packages
            foreach ($packages as $index => $package) {
                Package::create([
                    'packageable_id' => $vendor->id,
                    'packageable_type' => Vendor::class,
                    'name' => $package['name'],
                    'description' => $package['description'],
                    'price' => $package['price'],
                    'price_unit' => $package['price_unit'] ?? 'per booking',
                    'is_featured' => $index === 1,
                    'sort_order' => $index + 1,
                    'active' => true,
                ]);
            }

            // Associate vendor with random agencies (30% chance for each)
            foreach ($agencies as $agency) {
                if (rand(1, 100) <= 30) {
                    $vendor->agencies()->attach($agency->id, [
                        'status' => rand(1, 100) <= 80 ? 'approved' : 'pending',
                        'commission_rate' => rand(10, 20),
                        'is_preferred' => rand(1, 100) <= 20,
                        'visible_on_agency_profile' => true,
                        'approved_at' => now()->subDays(rand(1, 90)),
                    ]);
                }
            }

            // Associate with event types
            $vendorEventTypes = $eventTypes->random(rand(3, 8))->values();
            $vendor->eventTypes()->attach($vendorEventTypes);
        }

        $this->command->info('✓ Created ' . Vendor::count() . ' vendors with services and packages');
    }
}
