<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $bookingId = $request->query('booking');
        $booking = Booking::with('bookable')->findOrFail($bookingId);

        if ($booking->client_id !== Auth::user()->client->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already reviewed
        $hasReviewed = Review::where('client_id', $booking->client_id)
            ->where('reviewable_id', $booking->bookable_id)
            ->where('reviewable_type', $booking->bookable_type)
            ->exists();

        if ($hasReviewed) {
            return redirect()->route('dashboard')->with('error', 'You have already reviewed this booking.');
        }

        return view('client.review_create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::user()->client->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
        ]);

        $review = new Review();
        $review->client_id = $booking->client_id;
        $review->reviewable_id = $booking->bookable_id;
        $review->reviewable_type = $booking->bookable_type;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->pros = $validated['pros'] ?? null;
        $review->cons = $validated['cons'] ?? null;
        $review->event_date = $booking->event_date;
        $review->is_verified_purchase = true;
        // Default to approved to skip moderation queue for simplicity, or set false if a custom settings is present.
        $review->is_approved = true;

        $review->save();

        if ($review->reviewable) {
            $review->reviewable->updateRatingStats();
        }

        return redirect()->route('dashboard')->with('success', 'Your review has been successfully submitted!');
    }
}
