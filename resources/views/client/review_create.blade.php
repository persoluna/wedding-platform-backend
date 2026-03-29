<x-layouts.app>
<div class="container mx-auto px-4 py-8 max-w-2xl mt-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Leave a Review</h2>
            <span class="px-3 py-1 bg-green-50 text-green-700 text-sm font-medium rounded-full flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verified Purchase
            </span>
        </div>

        <div class="p-6 bg-gray-50/50">
            <div class="flex items-center space-x-4 mb-6">
                @if($booking->bookable->media->isNotEmpty())
                    <img src="{{ Storage::url($booking->bookable->media->first()->file_path) }}" alt="{{ $booking->bookable->name }}" class="w-16 h-16 rounded-lg object-cover">
                @else
                    <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h3 class="font-medium text-gray-900">{{ $booking->bookable->name ?? 'Vendor' }}</h3>
                    <p class="text-sm text-gray-500">Event Date: {{ $booking->event_date->format('M j, Y') }}</p>
                </div>
            </div>

            <form action="{{ route('review.store', $booking->id) }}" method="POST">
                @csrf

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-stone-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-2" id="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-rating="{{ $i }}" class="star-btn focus:outline-none text-stone-300 hover:text-amber-400 transition-colors">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required value="{{ old('rating', 5) }}">
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-stone-700 mb-2">Your Experience</label>
                    <textarea id="comment" name="comment" rows="4" class="w-full rounded-lg border-stone-300 focus:border-champagne-500 focus:ring-champagne-500 shadow-sm" placeholder="Tell others about your experience..." required>{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pros (Optional) -->
                <div class="mb-6">
                    <label for="pros" class="block text-sm font-medium text-stone-700 mb-2">Pros <span class="text-stone-400 font-normal">(Optional)</span></label>
                    <input type="text" id="pros" name="pros" value="{{ old('pros') }}" class="w-full rounded-lg border-stone-300 focus:border-champagne-500 focus:ring-champagne-500 shadow-sm" placeholder="e.g., Very professional, great communication">
                    @error('pros')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cons (Optional) -->
                <div class="mb-6">
                    <label for="cons" class="block text-sm font-medium text-stone-700 mb-2">Cons <span class="text-stone-400 font-normal">(Optional)</span></label>
                    <input type="text" id="cons" name="cons" value="{{ old('cons') }}" class="w-full rounded-lg border-stone-300 focus:border-champagne-500 focus:ring-champagne-500 shadow-sm" placeholder="e.g., Ran a bit late">
                    @error('cons')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-stone-700 bg-white border border-stone-300 rounded-lg hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-champagne-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-champagne-600 hover:bg-champagne-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-champagne-500 transition-colors shadow-sm">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');

        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                if (starRating <= rating) {
                    star.classList.remove('text-stone-300');
                    star.classList.add('text-amber-400');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-stone-300');
                }
            });
        }

        updateStars(ratingInput.value);

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                updateStars(rating);
            });

            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                updateStars(rating);
            });
        });

        document.getElementById('star-rating').addEventListener('mouseout', function() {
            updateStars(ratingInput.value);
        });
    });
</script>
</x-layouts.app>
