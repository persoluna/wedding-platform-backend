<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DemoInquirySeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo inquiries already exist
        if (Inquiry::count() > 0) {
            $this->command->info('⏭ Demo inquiries already seeded, skipping...');
            return;
        }

        $clients = Client::with('user')->get();
        $vendors = Vendor::with('user')->get();
        $agencies = Agency::with('user')->get();

        // ═══════════════════════════════════════════════════════════════════
        // VENDOR INQUIRIES
        // ═══════════════════════════════════════════════════════════════════

        $vendorInquiryTemplates = [
            // Photography inquiries
            [
                'category_pattern' => 'Photo',
                'messages' => [
                    ['from_client', 'Hi! We saw your portfolio and absolutely loved your work. We\'re getting married on {date} at {venue} and would love to discuss photography packages. Our budget is around {budget}. Could you please share your availability and pricing?'],
                    ['from_vendor', 'Thank you so much for reaching out! Congratulations on your upcoming wedding! 🎉 I checked my calendar and I\'m available on {date}. I\'d love to know more about your vision - are you looking for candid style, traditional, or a mix of both? Also, how many events are we looking at covering?'],
                    ['from_client', 'That\'s great to hear! We\'re looking for primarily candid photography with some traditional family portraits. We have 3 events - Mehndi, Wedding ceremony, and Reception. Would you be able to cover all three?'],
                    ['from_vendor', 'Absolutely! I have a perfect package for 3-event coverage. It includes 2 photographers, drone shots for the wedding day, and a cinematic teaser. I\'ll send you a detailed proposal with pricing via email. When would be a good time for a video call to discuss your vision in detail?'],
                ],
                'status' => 'responded',
            ],
            [
                'category_pattern' => 'Photo',
                'messages' => [
                    ['from_client', 'Hello, I\'m looking for a photographer for my pre-wedding shoot. We want to do it in the mountains - either Manali or Ladakh. Do you do destination pre-wedding shoots?'],
                    ['from_vendor', 'Hi! Yes, I absolutely love destination shoots! Both Manali and Ladakh are stunning locations. Ladakh offers more dramatic landscapes while Manali has beautiful greenery. What time of year are you planning this? The season really affects which location works better.'],
                    ['from_client', 'We\'re thinking August. And what would be the cost including travel?'],
                    ['from_vendor', 'August is perfect for Ladakh - clear skies and the landscapes are incredible! For a 2-day shoot in Ladakh, including my travel, accommodation, and 150+ edited photos, the package comes to ₹1,20,000. This includes Pangong Lake, Nubra Valley, and local monastery shoots. Shall I share some samples from my previous Ladakh shoots?'],
                    ['from_client', 'Yes please! Also, can my family come for part of the shoot?'],
                ],
                'status' => 'in_progress',
            ],

            // Catering inquiries
            [
                'category_pattern' => 'Cater',
                'messages' => [
                    ['from_client', 'Namaste! We are looking for catering services for our wedding on {date}. We expect around {guest_count} guests and need both vegetarian and non-vegetarian options. The venue is {venue}. Can you provide a quote?'],
                    ['from_vendor', 'Namaste! Thank you for considering us. For {guest_count} guests with mixed menu, I\'d recommend our Premium Wedding Package. It includes 15 vegetarian items + 8 non-veg items, live counters for chaat and kebabs, and complete service setup. At {venue}, we\'ve done several weddings before. Would you like to schedule a food tasting session?'],
                    ['from_client', 'That sounds good! We want authentic North Indian food with some South Indian options too. Many guests are from Chennai. Also need a dedicated vegetarian cooking area - some family members are strict vegetarians.'],
                    ['from_vendor', 'Absolutely understood! We maintain completely separate vegetarian and non-vegetarian kitchens with dedicated utensils. For South Indian options, we can add idli-vada-dosa live counter and authentic sambar-rasam. Let me work out a customized menu for you. Are there any specific dishes the families are expecting? Sometimes the must-haves make all the difference!'],
                ],
                'status' => 'responded',
            ],
            [
                'category_pattern' => 'Cater',
                'messages' => [
                    ['from_client', 'Hi, need urgent catering for a small wedding - 100 guests on {date}. Only vegetarian. Budget is tight - around ₹80,000 total. Is this possible?'],
                    ['from_vendor', 'Hi! Yes, we can definitely work within ₹80,000 for 100 guests. At ₹800 per plate, I can offer a good 10-item menu with starters, main course, dal-chawal, rotis, 2 desserts, and welcome drinks. The setup would be basic but presentable. Would you like to see the menu options?'],
                ],
                'status' => 'new',
                'is_urgent' => true,
            ],

            // Makeup inquiries
            [
                'category_pattern' => 'Makeup',
                'messages' => [
                    ['from_client', 'Hi! I\'m the bride and getting married on {date}. Saw your work on Instagram and loved the natural glam looks. I have oily skin and am worried about makeup lasting through the long ceremonies. Do you do airbrush?'],
                    ['from_vendor', 'Hello beautiful bride-to-be! 💕 Congratulations! Yes, I specialize in HD airbrush makeup which is PERFECT for oily skin. It lasts 12-16 hours easily - I\'ve had brides go through 8-hour ceremonies looking fresh! I\'d love to do a trial session so we can find your perfect look and test the longevity. When can you come to my studio?'],
                    ['from_client', 'That\'s reassuring! I can come next weekend. Also, my mom and sister would need makeup on the wedding day. What are your family rates?'],
                    ['from_vendor', 'Perfect! Book any slot next Saturday or Sunday through my website. For family, I charge ₹12,000 per person for HD makeup with hairstyling. If you\'re booking for 3+ family members along with bridal, I offer a 15% discount on family makeup. I also have a great team member who can do family makeup while I focus 100% on you!'],
                    ['from_client', 'That sounds great. Can you also suggest what makeup style would go with a red Sabyasachi lehenga?'],
                ],
                'status' => 'responded',
            ],

            // Decoration inquiries
            [
                'category_pattern' => 'Decor',
                'messages' => [
                    ['from_client', 'Hello, we need complete wedding decoration for our wedding at {venue}. Our theme is royal Mughal with lots of white flowers. Budget is around ₹8-10 lakhs for all functions. Please share what\'s possible.'],
                    ['from_vendor', 'What a gorgeous theme choice! Mughal with white flowers - I\'m already visualizing mogra jaalis, phool chandnis, and a stunning all-white mandap! At ₹8-10 lakhs for all functions, we can create something truly magical. Let me understand better - how many functions are we decorating? And is the venue indoor, outdoor, or mixed?'],
                    ['from_client', 'We have mehndi (outdoor lawn), wedding ceremony (indoor hall), and reception (outdoor with tent). The venue is a farmhouse with beautiful trees.'],
                    ['from_vendor', 'Oh perfect - farmhouse weddings give us so much to work with! Here\'s my initial thought: Mehndi can have a colorful Moroccan vibe as a contrast, Wedding mandap in full Mughal glory with white roses and mogra, Reception with elegant white and gold theme with crystal elements. I\'d love to do a venue visit. This weekend?'],
                ],
                'status' => 'in_progress',
            ],

            // DJ inquiries
            [
                'category_pattern' => 'DJ',
                'messages' => [
                    ['from_client', 'Hi DJ! We need DJ services for our sangeet on {date}. Around 300 guests, mostly young crowd. We want full-on Bollywood and Punjabi music - no slow boring stuff! Can you handle the energy?'],
                    ['from_vendor', 'Bro, you\'ve come to the right place! 🔥 My sangeets are LEGENDARY - ask anyone in Delhi! I guarantee your dance floor won\'t be empty for a single second. I bring my premium sound system, moving heads, CO2 jets, and if you want, even a confetti cannon for the couple\'s entry! What\'s the venue? I\'ll check if we need extra bass for outdoor.'],
                    ['from_client', 'Haha love the energy! It\'s at a farmhouse in Chattarpur. Also need good speakers for the choreographed performances - families have prepared 8 dances!'],
                    ['from_vendor', 'Perfect! For farmhouse I\'ll bring extra subs - outdoor needs more bass. For performances, I\'ll coordinate with your choreographer for smooth song transitions and mic setup for any anchoring. I also do live mixing so I can read the crowd and keep the vibe going. One question - do you want me to MC the event too or do you have someone?'],
                ],
                'status' => 'responded',
            ],

            // Venue inquiries
            [
                'category_pattern' => 'Resort|Palace|Venue|Hall|Banquet',
                'messages' => [
                    ['from_client', 'Hello, looking to book your venue for our wedding on {date}. We expect around {guest_count} guests. Could you please share availability, pricing, and what\'s included?'],
                    ['from_vendor', 'Thank you for considering us for your special day! I\'ve checked our calendar and we do have availability on {date}. For {guest_count} guests, I\'d recommend our Grand Ballroom + Garden Lawn combo. This gives you indoor backup while enjoying the outdoor beauty. The rental includes basic lighting, furniture, valet parking, and bridal suite. Shall I arrange a site visit?'],
                    ['from_client', 'Yes, would love to visit. Also, do you have in-house catering or can we get outside caterers?'],
                    ['from_vendor', 'We offer both options! Our in-house catering is excellent and many couples prefer it for the seamless coordination. However, we do allow outside caterers with a nominal service charge. During your visit, I can arrange a tasting session if you\'d like to try our food. What day works for you this week?'],
                ],
                'status' => 'responded',
            ],

            // Mehndi artist inquiries
            [
                'category_pattern' => 'Mehndi',
                'messages' => [
                    ['from_client', 'Hi! I need mehndi services for my wedding. I want full bridal mehndi with groom\'s portrait and our love story depicted. Also need mehndi for about 30 family members. Is this possible?'],
                    ['from_vendor', 'Hello! Absolutely! Portrait mehndi is my specialty - I\'ve done some incredible detailed work. For full bridal mehndi with portrait and story elements, I need about 4-5 hours. It\'s detailed work but the result is stunning! For 30 family members, I\'d suggest bringing my team of 3 artists. They can work simultaneously while I focus on your bridal mehndi.'],
                    ['from_client', 'How many days before wedding should I get it done? And will the color be dark enough by wedding day?'],
                    ['from_vendor', 'Great question! Ideally, get bridal mehndi done 2 days before wedding. Apply the paste, keep it for 6-8 hours (overnight is best), and the color develops beautifully by day 2. I also provide a special aftercare kit with lemon-sugar solution and oil that deepens the color. By your wedding day, it\'ll be a rich, dark maroon! 🙌'],
                ],
                'status' => 'in_progress',
            ],

            // Pandit inquiries
            [
                'category_pattern' => 'Pandit',
                'messages' => [
                    ['from_client', 'Namaste Panditji, we are looking for a learned pandit for our son\'s wedding on {date}. We want all rituals performed properly with explanations for the young generation. Location is {venue}.'],
                    ['from_vendor', 'Namaste! I\'d be honored to perform the ceremonies for your son\'s wedding. I always explain each ritual in both Sanskrit and Hindi/English so everyone understands the beautiful meaning behind our traditions. For a complete wedding with all 7 pheras, kanyadaan, and all traditional elements, the ceremony takes about 2.5-3 hours. Shall I share my approach to the ceremonies?'],
                    ['from_client', 'Yes please. We are Marwari and want all Marwari traditions followed. Our family pandit couldn\'t travel for this.'],
                    ['from_vendor', 'I have extensive experience with Marwari weddings. I know the specific variations - from the unique kumkum tilak to the Marwari-style pheras and the special aashirwaad mantras. I\'ll also coordinate with your family\'s elders to include any family-specific traditions. I\'ll send you a detailed ceremony outline for family approval.'],
                ],
                'status' => 'responded',
            ],

            // Simple new inquiry
            [
                'category_pattern' => '',
                'messages' => [
                    ['from_client', 'Hi, interested in your services for upcoming wedding. Please call me to discuss.'],
                ],
                'status' => 'new',
            ],
        ];

        // ═══════════════════════════════════════════════════════════════════
        // AGENCY INQUIRIES
        // ═══════════════════════════════════════════════════════════════════

        $agencyInquiryTemplates = [
            [
                'messages' => [
                    ['from_client', 'Hello! We are planning our wedding for {date} at {venue}. We need a complete wedding planning service as both of us are working professionals and don\'t have time to coordinate everything. Our budget is around {budget}. Can you help?'],
                    ['from_agency', 'Congratulations on your upcoming wedding! 🎊 We completely understand the challenges working couples face. That\'s exactly why we exist! At {budget}, we can offer you comprehensive planning covering vendor management, design, and coordination. Let me understand your vision better - what kind of wedding are you dreaming of? Grand and traditional, or intimate and modern?'],
                    ['from_client', 'We want something elegant but not over the top. Around 300 guests. Traditional ceremonies but contemporary décor. And honestly, we need someone to just tell us what to do and when - we\'re clueless about wedding planning!'],
                    ['from_agency', 'Ha! You\'re not alone - 80% of our couples say the same thing! Don\'t worry, that\'s our job. We\'ll create a complete timeline, checklist, and guide you through every decision. First step is always a detailed consultation where we understand both families\' expectations. Can we schedule a 90-minute meeting this weekend? In person or video call - whatever suits you.'],
                    ['from_client', 'Video call would be great - we\'re both traveling for work. Saturday 4 PM?'],
                ],
                'status' => 'in_progress',
            ],
            [
                'messages' => [
                    ['from_client', 'Hi! Looking for destination wedding planning in Udaipur. 200 guests, February next year. Is it too late to start planning?'],
                    ['from_agency', 'Not at all! February is wedding season in Udaipur, but with 8-9 months lead time, we can absolutely pull off an amazing celebration. However, venue booking should be our TOP priority as premium properties fill up fast. Do you have any specific venues in mind? Oberoi, Leela, or heritage properties like Jagmandir?'],
                    ['from_client', 'We loved Jagmandir from pictures but not sure if it fits our budget of 50 lakhs for everything.'],
                    ['from_agency', 'Let me be honest - Jagmandir venue alone is around 15-20 lakhs for a 2-day wedding. At 50 lakhs total, it would be tight but not impossible if we\'re smart about other vendors. Alternatively, there are stunning heritage havelis that give the same regal feel at half the price. Would you be open to exploring those options too?'],
                ],
                'status' => 'responded',
            ],
            [
                'messages' => [
                    ['from_client', 'Need help with my daughter\'s wedding. We\'re a traditional family and want everything done properly. Budget is not a constraint but the wedding should be tasteful, not show-offy. {venue} is booked. 500 guests expected.'],
                    ['from_agency', 'What a wonderful approach to wedding planning! Creating an elegant, sophisticated celebration is always more impactful than extravagance. With {venue} already booked, you\'re off to a great start. For 500 guests, we\'ll ensure every detail - from welcome experience to vidaai - reflects your family\'s values. May I know the wedding date and which ceremonies you\'ll be hosting?'],
                ],
                'status' => 'new',
            ],
            [
                'messages' => [
                    ['from_client', 'We need day-of coordination only. Everything is planned but we need a professional team on wedding days to manage. 3 functions at {venue}. What are your charges?'],
                    ['from_agency', 'Smart choice! Day-of coordination ensures everything you\'ve planned executes flawlessly. For 3 functions at {venue}, we\'d provide a lead coordinator + 2 assistants per event. We\'ll take over vendor coordination 2 weeks before, create detailed timelines, manage setup, and handle any fires on the day! Our day-of package starts at ₹75,000. Want me to share the detailed inclusions?'],
                    ['from_client', 'Yes please. And do you need to meet vendors before the wedding?'],
                    ['from_agency', 'Ideally yes - we do a final walkthrough with all vendors 1 week before. This is when we collect contact numbers, confirm delivery times, and brief everyone on the timeline. It\'s a 2-hour meeting at the venue. This prep makes event days run seamlessly. We\'ve rescued many DIY weddings with our coordination! 😊'],
                ],
                'status' => 'responded',
            ],
            [
                'messages' => [
                    ['from_client', 'URGENT - Our wedding planner cancelled on us 3 weeks before the wedding! {date} at {venue}. Most vendors are booked but need someone to coordinate everything. PLEASE HELP!'],
                    ['from_agency', 'Oh no, that\'s incredibly stressful! 😟 But don\'t panic - we\'ve handled emergency takeovers before. First, breathe! Let\'s jump on a call TODAY to assess the situation. I need to see all vendor contracts, payments made, and what\'s pending. We can stabilize this. What time can you talk? I\'m clearing my schedule for you.'],
                    ['from_client', 'Thank you so much! Can talk in 1 hour. Will compile all documents.'],
                    ['from_agency', 'Perfect. Create a shared Google Drive folder with all contracts, vendor contacts, and any design/decor references you had. I\'ll review before our call. And please - don\'t make any decisions or cancellations until we talk. We\'ll figure this out together! 💪'],
                ],
                'status' => 'in_progress',
                'is_urgent' => true,
            ],
        ];

        $inquiryCount = 0;

        // Create vendor inquiries
        foreach ($clients as $client) {
            // Each client makes 2-4 vendor inquiries
            $numInquiries = rand(2, 4);
            $usedVendors = [];

            for ($i = 0; $i < $numInquiries; $i++) {
                // Pick a random vendor not already contacted by this client
                $vendor = $vendors->whereNotIn('id', $usedVendors)->random();
                $usedVendors[] = $vendor->id;

                // Find matching template or use generic
                $template = collect($vendorInquiryTemplates)
                    ->filter(function($t) use ($vendor) {
                        return empty($t['category_pattern']) ||
                               preg_match('/'.$t['category_pattern'].'/i', $vendor->category->name ?? '');
                    })
                    ->random();

                $inquiry = Inquiry::create([
                    'client_id' => $client->id,
                    'vendor_id' => $vendor->id,
                    'name' => $client->user->name,
                    'email' => $client->user->email,
                    'phone' => $client->phone,
                    'event_date' => $client->wedding_date,
                    'event_location' => $client->wedding_city . ', ' . $client->wedding_state,
                    'guest_count' => $client->guest_count,
                    'budget' => $client->budget,
                    'message' => $this->formatMessage(
                        $template['messages'][0][1] ?? 'Interested in your services for our wedding.',
                        $client,
                        $vendor
                    ),
                    'status' => $template['status'],
                    'is_urgent' => $template['is_urgent'] ?? false,
                    'source' => collect(['website', 'instagram', 'referral', 'google'])->random(),
                    'responded_at' => in_array($template['status'], ['responded', 'in_progress', 'booked'])
                        ? now()->subDays(rand(1, 14))
                        : null,
                    'created_at' => now()->subDays(rand(5, 60)),
                ]);

                // Create conversation messages
                $this->createMessages($inquiry, $template['messages'], $client, $vendor, null);
                $inquiryCount++;
            }
        }

        // Create agency inquiries
        foreach ($clients->take(10) as $client) {
            $agency = $agencies->random();
            $template = collect($agencyInquiryTemplates)->random();

            $inquiry = Inquiry::create([
                'client_id' => $client->id,
                'agency_id' => $agency->id,
                'name' => $client->user->name,
                'email' => $client->user->email,
                'phone' => $client->phone,
                'event_date' => $client->wedding_date,
                'event_location' => $client->wedding_city . ', ' . $client->wedding_state,
                'guest_count' => $client->guest_count,
                'budget' => $client->budget,
                'message' => $this->formatMessage(
                    $template['messages'][0][1] ?? 'Looking for wedding planning services.',
                    $client,
                    null,
                    $agency
                ),
                'status' => $template['status'],
                'is_urgent' => $template['is_urgent'] ?? false,
                'source' => collect(['website', 'instagram', 'referral', 'wedding_exhibition'])->random(),
                'responded_at' => in_array($template['status'], ['responded', 'in_progress', 'booked'])
                    ? now()->subDays(rand(1, 14))
                    : null,
                'created_at' => now()->subDays(rand(5, 60)),
            ]);

            $this->createMessages($inquiry, $template['messages'], $client, null, $agency);
            $inquiryCount++;
        }

        $this->command->info('✓ Created ' . $inquiryCount . ' inquiries with conversations');
    }

    private function formatMessage(string $template, Client $client, ?Vendor $vendor = null, ?Agency $agency = null): string
    {
        $replacements = [
            '{date}' => $client->wedding_date?->format('F j, Y') ?? 'TBD',
            '{venue}' => $client->wedding_venue ?? 'our venue',
            '{budget}' => '₹' . number_format($client->budget ?? 0),
            '{guest_count}' => $client->guest_count ?? '200',
            '{city}' => $client->wedding_city ?? 'the city',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    private function createMessages(Inquiry $inquiry, array $messages, Client $client, ?Vendor $vendor, ?Agency $agency): void
    {
        $baseTime = $inquiry->created_at;

        foreach ($messages as $index => $message) {
            [$sender, $content] = $message;

            $formattedContent = $this->formatMessage($content, $client, $vendor, $agency);

            if ($sender === 'from_client') {
                $senderId = $client->user_id;
                $recipientId = $vendor?->user_id ?? $agency?->user_id;
            } else {
                $senderId = $vendor?->user_id ?? $agency?->user_id;
                $recipientId = $client->user_id;
            }

            if (!$senderId || !$recipientId) continue;

            Message::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $senderId,
                'recipient_id' => $recipientId,
                'message' => $formattedContent,
                'read_at' => $index < count($messages) - 1 ? $baseTime->addHours($index + 1) : null,
                'is_system_message' => false,
                'created_at' => $baseTime->addHours($index * rand(2, 8)),
            ]);
        }
    }
}
