<div class="bg-stone-50 min-h-screen pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-serif text-slate-900 mb-4 tracking-tight">Explore Nuptial</h1>
            <p class="text-lg text-slate-500">Discover premium vendors and agencies to make your dream wedding a reality.</p>
        </div>

        <!-- Horizontal Filters -->
        <div class="bg-white rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 p-3 sm:p-5 mb-10">
            <div class="flex flex-col lg:flex-row items-center gap-4">

                <!-- Main Search -->
                <div class="w-full lg:flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search by exact name..." class="pl-11 w-full bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-14 text-slate-700">
                </div>

                <!-- City Search -->
                <div class="w-full lg:w-1/4 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.400ms="city" placeholder="Location or City" class="pl-11 w-full bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-14 text-slate-700">
                </div>

                <!-- Type Select -->
                <div class="w-full lg:w-48 relative">
                    <select wire:model.live="type" class="w-full bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-14 text-slate-700 font-medium cursor-pointer">
                        <option value="all">All Listings</option>
                        <option value="vendor">Vendors Only</option>
                        <option value="agency">Agencies Only</option>
                    </select>
                </div>

                @if($type !== 'agency')
                <!-- Category Select -->
                <div class="w-full lg:w-48 relative">
                    <select wire:model.live="category_id" class="w-full bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-14 text-slate-700 cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <!-- Expandable Price Filters (if typing vendors) -->
            @if($type !== 'agency')
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 px-2 pb-2">
                <div class="flex items-center gap-4 flex-1 w-full sm:w-auto">
                    <span class="text-sm font-medium text-slate-400 tracking-wide uppercase whitespace-nowrap">Price Range:</span>
                    <div class="flex items-center gap-3 w-full max-w-sm">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-medium">$</span>
                            <input type="number" wire:model.live.debounce.500ms="min_price" placeholder="Min" class="pl-8 w-full bg-slate-50 border-transparent rounded-xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-11 text-sm font-medium">
                        </div>
                        <span class="text-slate-300">-</span>
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-medium">$</span>
                            <input type="number" wire:model.live.debounce.500ms="max_price" placeholder="Max" class="pl-8 w-full bg-slate-50 border-transparent rounded-xl focus:bg-white focus:border-champagne-400 focus:ring-4 focus:ring-champagne-500/10 transition-all duration-300 h-11 text-sm font-medium">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end w-full sm:w-auto">
                    <button wire:click="clearFilters" class="text-sm font-medium text-slate-400 hover:text-rose-500 transition-colors flex items-center gap-1.5 px-3 py-2 rounded-lg hover:bg-rose-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear Filters
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- Results Info -->
        <div class="mb-8 pl-2">
            <h2 class="text-2xl font-serif text-slate-900 tracking-tight">
                Recommended For You
                <span class="text-base font-sans font-normal text-slate-500 ml-2 bg-slate-100 px-3 py-1 rounded-full align-middle">{{ $listings->total() }} results</span>
            </h2>
        </div>

        <!-- Main Content Grid -->
        @if($listings->isEmpty())
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-200 shadow-sm flex flex-col items-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-slate-900 mb-2">No listings found</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">We couldn't find any resources matching your precise criteria. Try adjusting your filters or search location.</p>
                <button wire:click="clearFilters" class="inline-flex items-center justify-center px-6 py-3 rounded-full text-white bg-slate-900 hover:bg-slate-800 transition-all duration-300 font-medium shadow-md hover:shadow-xl hover:-translate-y-0.5">
                    Reset All Filters
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 gap-y-10">
                @foreach($listings as $listing)
                    <a wire:key="listing-{{ $listing->listing_type }}-{{ $listing->id }}" href="{{ url('listing/' . $listing->listing_type . '/' . $listing->slug) }}" class="group block h-full">
                        <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 hover:border-champagne-300 transition-all duration-500 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.03)] hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:-translate-y-2 h-full flex flex-col relative">
                            <div class="relative h-60 sm:h-72 bg-slate-100 overflow-hidden">
                                @php
                                    $imageUrl = null;
                                    if (!empty($listing->logo)) {
                                        $imageUrl = asset('storage/' . $listing->logo);
                                    } elseif ($listing->hasMedia('logo')) {
                                        $imageUrl = $listing->getFirstMediaUrl('logo');
                                    } elseif ($listing->hasMedia('avatar')) {
                                        $imageUrl = $listing->getFirstMediaUrl('avatar');
                                    }

                                    if (!$imageUrl) {
                                        $imageUrl = "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=600";
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $listing->business_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]" />

                                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Featured/Type Badges -->
                                <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                    @if($listing->featured || $listing->premium)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold tracking-wide uppercase bg-champagne-500 text-white shadow-lg backdrop-blur-sm">
                                            <svg class="-ml-1 mr-1.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                            Featured
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold tracking-wide uppercase bg-white/95 text-slate-800 shadow-lg backdrop-blur-sm">
                                            {{ ucfirst($listing->listing_type) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Alpine Save Button -->
                                <div role="button" @click.prevent="$store.savedListings.toggle({
                                        id: '{{ $listing->id }}',
                                        type: '{{ $listing->listing_type }}',
                                        title: @js($listing->business_name),
                                        image: @js($imageUrl),
                                        location: @js($listing->city . ', ' . ($listing->state ?? 'NY')),
                                        rating: @js(number_format($listing->avg_rating ?? 5.0, 1)),
                                        reviews: @js($listing->review_count ?? 12),
                                        slug: @js($listing->slug)
                                    })"
                                    class="absolute top-4 right-4 p-2.5 rounded-full backdrop-blur-md shadow-lg transition-transform duration-300 z-10 hover:scale-110 active:scale-95"
                                    :class="$store.savedListings.has('{{ $listing->id }}', '{{ $listing->listing_type }}') ? 'bg-rose-50 border border-rose-200 text-rose-500' : 'bg-black/30 border border-white/20 text-white hover:text-rose-400 hover:bg-white/95'"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                         :fill="$store.savedListings.has('{{ $listing->id }}', '{{ $listing->listing_type }}') ? 'currentColor' : 'none'"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                         <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                    </svg>
                                </div>

                                <!-- Bottom Info Overlay -->
                                <div class="absolute bottom-0 left-0 right-0 p-5 pt-12 z-10">
                                    <h3 class="text-2xl font-serif text-white mb-2 leading-tight drop-shadow-md">
                                        {{ $listing->business_name }}
                                    </h3>
                                    <div class="flex items-center justify-between text-white/90">
                                        <p class="text-sm flex items-center gap-1.5 font-medium">
                                            <svg class="w-4 h-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            {{ $listing->city ?? 'Remote' }}{{ isset($listing->state) ? ', ' . $listing->state : '' }}
                                        </p>
                                        <div class="flex items-center bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-lg">
                                            <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400 mr-1.5" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                            <span class="text-sm font-bold text-white">{{ number_format($listing->avg_rating ?? 5.0, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col grow bg-white">
                                <div class="mt-auto flex items-center justify-between">
                                    <div class="text-sm">
                                        @if($listing->listing_type === 'vendor')
                                            <span class="text-[10px] text-slate-400 block tracking-widest uppercase font-bold mb-1">Category</span>
                                            <span class="font-semibold text-slate-800 truncate max-w-[140px] block" title="{{ $listing->category->name ?? 'Service' }}">
                                                {{ $listing->category->name ?? 'Service' }}
                                            </span>
                                        @else
                                            <span class="text-[10px] text-slate-400 block tracking-widest uppercase font-bold mb-1">Community</span>
                                            <span class="font-semibold text-slate-800">{{ $listing->review_count ?? 12 }}+ Verified Reviews</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        @if($listing->listing_type === 'vendor' && $listing->min_price)
                                            <span class="text-[10px] text-slate-400 block tracking-widest uppercase font-bold mb-1">Starts at</span>
                                            <span class="font-bold text-xl text-slate-900 tracking-tight">${{ number_format($listing->min_price) }}</span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-400 group-hover:bg-champagne-50 group-hover:text-champagne-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 mb-8 flex justify-center">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</div>
