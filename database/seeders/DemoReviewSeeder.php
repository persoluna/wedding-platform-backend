<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DemoReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if demo reviews already exist
        if (Review::count() > 0) {
            $this->command->info('⏭ Demo reviews already seeded, skipping...');
            return;
        }

        // Get completed bookings - these are eligible for reviews
        $completedBookings = Booking::where('status', 'completed')
            ->with(['client', 'bookable'])
            ->get();

        $reviewCount = 0;

        // Review templates by category
        $vendorReviewTemplates = [
            'Photo' => [
                5 => [
                    ['comment' => 'Absolutely stunning work! {vendor} captured every moment perfectly. The candid shots were magical - our families are still talking about how beautiful the photos are. The team was professional, unobtrusive, and made us feel comfortable throughout. The album quality exceeded our expectations!', 'pros' => 'Incredible candid shots, Professional team, Quick delivery', 'cons' => 'None at all!'],
                    ['comment' => 'Best decision we made was booking {vendor}. They understood exactly what we wanted - modern yet timeless photos. The pre-wedding shoot was so much fun, and the wedding day coverage was flawless. Highly recommend for any couple looking for quality photography!', 'pros' => 'Creative vision, Attention to detail, Great communication', 'cons' => 'Could include more edited photos in basic package'],
                    ['comment' => 'We were blown away by the quality! The photographer had this amazing ability to capture emotions. Looking at our wedding album still makes me cry happy tears. Worth every penny!', 'pros' => 'Emotional storytelling, Beautiful editing, Drone shots', 'cons' => null],
                ],
                4 => [
                    ['comment' => '{vendor} did a great job overall. The photos are beautiful and the team was professional. Minor delays in delivery but the quality made up for it. Would recommend!', 'pros' => 'Good quality, Nice team, Fair pricing', 'cons' => 'Slight delay in final delivery'],
                    ['comment' => 'Very happy with the photography. The candids are wonderful and captured the essence of our big day. Some traditional poses could have been better composed but overall very satisfied.', 'pros' => 'Great candids, Good editing, Friendly team', 'cons' => 'Traditional photos could be better'],
                ],
                3 => [
                    ['comment' => 'Decent photography service. The photos are good but we expected a bit more creativity based on their portfolio. The team was professional and delivered on time.', 'pros' => 'On-time delivery, Professional', 'cons' => 'Less creative than portfolio suggested'],
                ],
            ],
            'Cater' => [
                5 => [
                    ['comment' => 'The food was INCREDIBLE! {vendor} exceeded all our expectations. Every dish was delicious, presentation was beautiful, and the live counters were a huge hit. Our guests are still raving about the biryani and kebabs! The service staff was impeccable.', 'pros' => 'Delicious food, Excellent presentation, Great service', 'cons' => 'None'],
                    ['comment' => 'Hiring {vendor} was the best decision for our wedding catering. The taste was authentic, the variety was impressive, and not a single guest complained. They handled 500 guests smoothly!', 'pros' => 'Authentic taste, Huge variety, Smooth service', 'cons' => null],
                    ['comment' => 'Our guests haven\'t stopped talking about the food! The chaat counter was a massive hit, and the main course was restaurant quality. {vendor} made our wedding memorable.', 'pros' => 'Amazing live counters, Quality ingredients, Friendly staff', 'cons' => 'Dessert variety could be more'],
                ],
                4 => [
                    ['comment' => 'Really good catering experience. Food was tasty and well-presented. Service was smooth for most part. The paneer dishes could have been softer but overall happy with the experience.', 'pros' => 'Tasty food, Good variety, Timely service', 'cons' => 'Some dishes slightly overcooked'],
                    ['comment' => '{vendor} did a solid job. The non-veg items were excellent, and the service was professional. Pricing was fair for the quality delivered.', 'pros' => 'Good non-veg, Professional service', 'cons' => 'Veg options were average'],
                ],
                3 => [
                    ['comment' => 'Food was decent but not exceptional. Service was okay. They delivered what was promised but didn\'t go above and beyond. Adequate for the price point.', 'pros' => 'Decent food, Met basic expectations', 'cons' => 'Nothing special, average taste'],
                ],
            ],
            'Makeup' => [
                5 => [
                    ['comment' => 'I felt like a QUEEN on my wedding day! {vendor} understood my vision perfectly and created the most beautiful bridal look. The makeup lasted 14 hours without any touch-up needed. The trial session was so helpful in finalizing the perfect look.', 'pros' => 'Long-lasting, Perfect understanding of my vision, Patient and professional', 'cons' => 'None!'],
                    ['comment' => '{vendor} is pure magic! She made me feel so beautiful and confident. The airbrush makeup was flawless in photos and in person. My mom and sister also looked gorgeous. Highly highly recommend!', 'pros' => 'Flawless finish, Great with all skin types, Lovely person', 'cons' => null],
                    ['comment' => 'The best makeup artist I\'ve ever worked with! She listened to what I wanted, suggested improvements, and created a look that was even better than I imagined. The hair styling was equally stunning!', 'pros' => 'Expert skills, Creative suggestions, Beautiful hairstyling', 'cons' => 'Slightly expensive but worth it'],
                ],
                4 => [
                    ['comment' => 'Very happy with my bridal makeup! {vendor} was professional and skilled. The makeup photographed beautifully. Hairstyling could have been a bit more elaborate for the price, but overall satisfied.', 'pros' => 'Beautiful makeup, Professional', 'cons' => 'Hairstyling was basic'],
                    ['comment' => 'Did a great job with my wedding look. The makeup lasted through the ceremonies and I got so many compliments. Would recommend!', 'pros' => 'Long-lasting, Good technique', 'cons' => 'Running slightly late'],
                ],
                3 => [
                    ['comment' => 'The makeup was good but not exceptional. I had expected a more dramatic look based on the trial but it ended up being more subtle. Still looked nice in photos.', 'pros' => 'Clean work, Professional', 'cons' => 'Didn\'t match trial look exactly'],
                ],
            ],
            'Decor' => [
                5 => [
                    ['comment' => 'BREATHTAKING! {vendor} transformed our venue into something out of a fairy tale. Every corner was Instagram-worthy. The mandap was so beautiful that even our photographer was impressed. The floral arrangements were fresh and stunning all day!', 'pros' => 'Stunning creativity, Fresh flowers, Perfect execution', 'cons' => 'None at all'],
                    ['comment' => 'We wanted a royal Mughal theme and {vendor} absolutely nailed it! The attention to detail was incredible - from the entrance to the mandap to the stage. Every element was thoughtfully designed. Worth every rupee!', 'pros' => 'Theme execution, Attention to detail, Quality materials', 'cons' => null],
                    ['comment' => 'Our wedding venue looked like a dream! The decoration was elegant, tasteful, and exactly what we envisioned. The team worked through the night to make sure everything was perfect. Highly recommend!', 'pros' => 'Beautiful design, Hardworking team, Met all requirements', 'cons' => 'Setup took longer than expected but worth the wait'],
                ],
                4 => [
                    ['comment' => 'Beautiful decoration by {vendor}. The overall look was elegant and classy. A few minor things were different from the initial design but they adjusted quickly. Happy with the outcome!', 'pros' => 'Elegant design, Responsive team', 'cons' => 'Minor deviations from initial design'],
                    ['comment' => 'Good decoration work. The mandap looked lovely and the stage was well designed. Flowers were fresh. The lighting could have been better coordinated.', 'pros' => 'Nice mandap, Fresh flowers', 'cons' => 'Lighting could improve'],
                ],
                3 => [
                    ['comment' => 'Decent decoration but expected more for the price. The basic setup was okay but didn\'t have the wow factor we were hoping for.', 'pros' => 'Met basic requirements', 'cons' => 'Lacked wow factor, overpriced'],
                ],
            ],
            'DJ' => [
                5 => [
                    ['comment' => 'The BEST DJ ever! {vendor} kept our dance floor packed ALL NIGHT! Perfect mix of Bollywood, Punjabi, and English tracks. The energy was incredible. Even our grandparents were dancing! The sound quality was amazing and he read the crowd perfectly.', 'pros' => 'Great music selection, Amazing energy, Perfect sound quality', 'cons' => 'None!'],
                    ['comment' => 'If you want your guests to dance non-stop, book {vendor}! He knows exactly what to play and when. The transition between sangeet performances and party music was seamless. Our wedding was a hit thanks to him!', 'pros' => 'Crowd reading skills, Seamless transitions, Great equipment', 'cons' => null],
                    ['comment' => 'Our sangeet was LEGENDARY because of {vendor}! The LED lights, the sound system, everything was top-notch. He even learned a few of our family\'s favorite regional songs. Highly recommend!', 'pros' => 'Customized playlist, Great lights, Professional', 'cons' => 'A bit loud at times but that\'s what we wanted!'],
                ],
                4 => [
                    ['comment' => 'Very good DJ services. Music selection was great and kept people dancing. The lighting setup was nice. Would have preferred more interaction with the crowd during the party.', 'pros' => 'Good music, Nice lights', 'cons' => 'Less crowd interaction'],
                    ['comment' => '{vendor} did a solid job at our reception. Good mix of songs, professional setup. The MC services were helpful in keeping things moving.', 'pros' => 'Professional, Good music mix, MC services', 'cons' => 'Sound was a bit uneven at times'],
                ],
                3 => [
                    ['comment' => 'Okay DJ experience. Music was decent but not as high-energy as we hoped. Equipment was good though.', 'pros' => 'Good equipment', 'cons' => 'Could be more energetic'],
                ],
            ],
            'Mehndi' => [
                5 => [
                    ['comment' => 'My mehndi was the most beautiful I\'ve ever seen! {vendor} created an intricate design with my husband\'s portrait hidden in it - everyone was amazed! The color came out so dark and lasted almost 3 weeks. She\'s truly an artist!', 'pros' => 'Incredible artistry, Dark color, Amazing detail', 'cons' => 'None'],
                    ['comment' => '{vendor} is a mehndi goddess! The design was so detailed and beautiful. She was patient with my fidgeting and the result was stunning. My photos look amazing because of the beautiful mehndi!', 'pros' => 'Patient, Detailed work, Beautiful result', 'cons' => null],
                    ['comment' => 'Booked {vendor} for bridal mehndi and 25 family members. She brought a team who were all equally skilled. Everything was done on time and everyone loved their designs!', 'pros' => 'Team efficiency, Consistent quality, Time management', 'cons' => 'None at all'],
                ],
                4 => [
                    ['comment' => 'Beautiful mehndi design by {vendor}. The bridal design was intricate and pretty. Color was good. A few family members felt their designs were rushed but overall happy.', 'pros' => 'Beautiful bridal mehndi, Good color', 'cons' => 'Family mehndi could be more detailed'],
                    ['comment' => 'Good mehndi work. Design was pretty and color turned out well. Would recommend for bridal mehndi.', 'pros' => 'Pretty design, Good color', 'cons' => 'Took longer than expected'],
                ],
                3 => [
                    ['comment' => 'Decent mehndi. Design was simpler than discussed but looked nice. Color was okay - not as dark as promised.', 'pros' => 'Nice design', 'cons' => 'Color not as dark, simpler than discussed'],
                ],
            ],
            'Venue|Resort|Palace|Hall' => [
                5 => [
                    ['comment' => 'The venue was absolutely PERFECT! {vendor} exceeded all our expectations. The staff was incredibly helpful, the spaces were beautiful, and everything ran smoothly. Our guests are still talking about how stunning the venue was!', 'pros' => 'Beautiful property, Excellent staff, Smooth coordination', 'cons' => 'None'],
                    ['comment' => 'Dream wedding venue! The ballroom was gorgeous, the garden was well-maintained, and the bridal suite was luxurious. {vendor} made our wedding day stress-free with their professional team.', 'pros' => 'Gorgeous spaces, Professional team, Great facilities', 'cons' => null],
                    ['comment' => 'We couldn\'t have asked for a better venue. {vendor} went above and beyond - from accommodating our last-minute requests to ensuring all our guests were comfortable. Worth every penny!', 'pros' => 'Accommodating, Excellent service, Premium facilities', 'cons' => 'Parking was a bit tight'],
                ],
                4 => [
                    ['comment' => 'Beautiful venue with good facilities. The event spaces were lovely and staff was helpful. Food was above average. Minor issues with room service but overall great experience.', 'pros' => 'Beautiful spaces, Helpful staff', 'cons' => 'Room service could be faster'],
                    ['comment' => 'Good venue for weddings. Spaces are well-designed and maintained. Coordination with our vendors was smooth. Pricing is on the higher side but quality matches.', 'pros' => 'Well-maintained, Good coordination', 'cons' => 'Slightly expensive'],
                ],
                3 => [
                    ['comment' => 'Decent venue. The main hall was nice but other areas could be better maintained. Service was inconsistent - some staff great, others not so much.', 'pros' => 'Nice main hall', 'cons' => 'Inconsistent service, maintenance issues'],
                ],
            ],
            'Pandit' => [
                5 => [
                    ['comment' => 'Panditji conducted our wedding ceremony beautifully! He explained every ritual in both Sanskrit and Hindi so our younger generation understood the significance. The ceremony was emotional, meaningful, and perfectly timed. Highly recommend!', 'pros' => 'Knowledgeable, Great explanations, Perfect timing', 'cons' => 'None'],
                    ['comment' => '{vendor} made our wedding ceremony truly special. His deep knowledge of traditions and ability to conduct rituals with both authenticity and warmth created magical moments. Our families were very impressed!', 'pros' => 'Deep knowledge, Authentic, Warm personality', 'cons' => null],
                    ['comment' => 'Best decision to book Panditji! He coordinated perfectly with our wedding planner, the ceremony was beautiful, and he blessed us with such meaningful shlokas. Very professional!', 'pros' => 'Professional, Meaningful ceremony, Good coordination', 'cons' => 'None at all'],
                ],
                4 => [
                    ['comment' => 'Good ceremony conducted by Panditji. He knew the rituals well and explained them clearly. Ceremony ran a bit longer than planned but was meaningful.', 'pros' => 'Knowledgeable, Clear explanations', 'cons' => 'Ceremony ran long'],
                    ['comment' => '{vendor} did a nice job with our wedding rituals. Traditional and respectful. Would have appreciated more engagement with guests during explanations.', 'pros' => 'Traditional, Respectful', 'cons' => 'Could engage guests more'],
                ],
            ],
            // Default for other categories
            'default' => [
                5 => [
                    ['comment' => 'Absolutely wonderful experience with {vendor}! Professional, talented, and a pleasure to work with. They made our wedding day special and we couldn\'t be happier with their service. Highly recommend!', 'pros' => 'Professional, Talented, Excellent service', 'cons' => 'None'],
                    ['comment' => '{vendor} exceeded our expectations in every way. From the initial consultation to the wedding day execution, everything was perfect. Thank you for making our day memorable!', 'pros' => 'Exceeded expectations, Great communication, Perfect execution', 'cons' => null],
                ],
                4 => [
                    ['comment' => 'Very happy with {vendor}\'s services. Professional team, good quality work, and fair pricing. Minor hiccups but nothing major. Would recommend!', 'pros' => 'Professional, Good quality, Fair pricing', 'cons' => 'Minor issues'],
                    ['comment' => 'Good experience overall. {vendor} delivered what was promised and the team was pleasant to work with. Satisfied with the outcome.', 'pros' => 'Reliable, Pleasant team', 'cons' => 'Could be more innovative'],
                ],
                3 => [
                    ['comment' => 'Decent service by {vendor}. Met basic expectations but nothing extraordinary. Average experience for the price paid.', 'pros' => 'Met basic requirements', 'cons' => 'Average, nothing special'],
                ],
            ],
        ];

        $agencyReviewTemplates = [
            5 => [
                ['comment' => '{agency} made our wedding planning journey absolutely stress-free! From the first meeting to the last dance, their team handled everything with such professionalism and care. They understood our vision and brought it to life beyond our imagination. The coordination on wedding day was flawless!', 'pros' => 'Complete stress relief, Amazing coordination, Vision executed perfectly', 'cons' => 'None whatsoever!'],
                ['comment' => 'If you\'re getting married, just book {agency} and relax! They managed everything - vendors, family drama (yes, even that!), timelines, décor, everything. Our destination wedding in Udaipur was magical and we actually got to enjoy it because they handled all the work!', 'pros' => 'Total management, Problem solvers, Made us enjoy our wedding', 'cons' => null],
                ['comment' => 'Worth every penny! {agency} transformed our vague Pinterest boards into the wedding of our dreams. Their vendor recommendations were spot on, negotiations saved us money, and their on-ground team was incredible. Highly highly recommend!', 'pros' => 'Great vendor network, Budget management, Creative vision', 'cons' => 'Wish we could do it all over again!'],
            ],
            4 => [
                ['comment' => 'Great experience with {agency}. They handled most things smoothly and were always available for calls. A few miscommunications with vendors but nothing major. Happy with our wedding!', 'pros' => 'Good coordination, Always available, Handled vendors well', 'cons' => 'Some miscommunications'],
                ['comment' => '{agency} did a solid job planning our wedding. The team was professional and creative. Wish they had been more proactive with updates but overall satisfied with the outcome.', 'pros' => 'Professional, Creative ideas', 'cons' => 'Could be more proactive with updates'],
            ],
            3 => [
                ['comment' => 'Decent planning service. They helped coordinate vendors and logistics but we ended up doing more work than expected. For the price, expected more involvement.', 'pros' => 'Helped with logistics', 'cons' => 'Less hands-on than expected'],
            ],
        ];

        // Create reviews for vendor bookings
        foreach ($completedBookings as $booking) {
            // 75% of completed bookings leave reviews
            if (rand(1, 100) > 75) continue;

            $bookable = $booking->bookable;
            if (!$bookable) continue;

            // Determine rating (weighted towards positive)
            $rating = $this->getWeightedRating();

            // Find appropriate template
            if ($bookable instanceof Vendor) {
                $category = $bookable->category->name ?? '';
                $templates = null;

                foreach ($vendorReviewTemplates as $pattern => $ratingTemplates) {
                    if ($pattern === 'default') continue;
                    if (preg_match('/' . $pattern . '/i', $category)) {
                        $templates = $ratingTemplates;
                        break;
                    }
                }

                $templates = $templates ?? $vendorReviewTemplates['default'];
                $ratingLevel = $rating >= 5 ? 5 : ($rating >= 4 ? 4 : 3);
                $template = collect($templates[$ratingLevel] ?? $templates[5])->random();
                $businessName = $bookable->business_name;
            } else {
                // Agency review
                $ratingLevel = $rating >= 5 ? 5 : ($rating >= 4 ? 4 : 3);
                $template = collect($agencyReviewTemplates[$ratingLevel] ?? $agencyReviewTemplates[5])->random();
                $businessName = $bookable->business_name;
            }

            // Format the comment
            $comment = str_replace(
                ['{vendor}', '{agency}'],
                [$businessName, $businessName],
                $template['comment']
            );

            $review = Review::create([
                'client_id' => $booking->client_id,
                'reviewable_id' => $bookable->id,
                'reviewable_type' => get_class($bookable),
                'rating' => $rating,
                'comment' => $comment,
                'pros' => $template['pros'],
                'cons' => $template['cons'],
                'rating_breakdown' => $this->generateRatingBreakdown($rating),
                'event_date' => $booking->event_date,
                'is_verified_purchase' => true,
                'is_approved' => rand(1, 100) <= 95, // 95% approved
                'is_featured' => rand(1, 100) <= 10 && $rating >= 4, // 10% featured
                'vendor_response' => $this->maybeAddVendorResponse($rating, $businessName),
                'vendor_responded_at' => rand(1, 100) <= 60 ? now()->subDays(rand(1, 30)) : null,
                'created_at' => $booking->event_date?->addDays(rand(3, 30)) ?? now()->subDays(rand(10, 60)),
            ]);

            $reviewCount++;
        }

        // Update rating stats for all vendors and agencies
        Vendor::all()->each(fn($v) => $v->updateRatingStats());
        Agency::all()->each(fn($a) => $a->updateRatingStats());

        $this->command->info('✓ Created ' . $reviewCount . ' reviews');
    }

    private function getWeightedRating(): int
    {
        // Weighted distribution: mostly 4-5 stars
        $weights = [
            5 => 45,  // 45% chance
            4 => 35,  // 35% chance
            3 => 15,  // 15% chance
            2 => 4,   // 4% chance
            1 => 1,   // 1% chance
        ];

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $rating => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $rating;
            }
        }

        return 5;
    }

    private function generateRatingBreakdown(int $overallRating): array
    {
        // Generate sub-ratings that average close to overall rating
        $variation = 1;

        return [
            'quality' => min(5, max(1, $overallRating + rand(-$variation, $variation))),
            'communication' => min(5, max(1, $overallRating + rand(-$variation, $variation))),
            'value' => min(5, max(1, $overallRating + rand(-$variation, $variation))),
            'professionalism' => min(5, max(1, $overallRating + rand(-$variation, $variation))),
        ];
    }

    private function maybeAddVendorResponse(int $rating, string $businessName): ?string
    {
        // 60% of reviews get responses, higher for lower ratings
        if (rand(1, 100) > 60) return null;

        if ($rating >= 4) {
            $responses = [
                "Thank you so much for your kind words! It was an absolute pleasure being part of your special day. We wish you a lifetime of happiness together! 💕 - Team {$businessName}",
                "We're thrilled that you had a wonderful experience! Your wedding was truly beautiful and we loved being part of it. Thank you for trusting us! - {$businessName}",
                "Thank you for this lovely review! Working with you both was a joy. Wishing you all the best in your married life! ✨ - Team {$businessName}",
                "Your kind words mean so much to us! Thank you for choosing {$businessName}. We cherish couples like you who value our work. Best wishes always!",
            ];
        } elseif ($rating >= 3) {
            $responses = [
                "Thank you for your feedback. We're glad you had a good experience overall. We're always working to improve and appreciate your honest review. Best wishes! - {$businessName}",
                "We appreciate your review and feedback. We'll take your suggestions into consideration for future improvements. Wishing you happiness! - Team {$businessName}",
            ];
        } else {
            $responses = [
                "We sincerely apologize that your experience didn't meet expectations. We take all feedback seriously and would love the opportunity to discuss this further. Please reach out to us directly. - {$businessName}",
                "Thank you for sharing your experience. We're sorry to hear you weren't fully satisfied. Your feedback helps us improve. We'd appreciate the chance to make things right. - Team {$businessName}",
            ];
        }

        return str_replace('{business}', $businessName, collect($responses)->random());
    }
}
