<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vendor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
    'category_id',
    'created_by_user_id',
    'owning_agency_id',
        'business_name',
        'slug',
        'description',
        'logo',
        'banner',
        'website',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'phone',
        'email',
        'whatsapp',
        'min_price',
        'max_price',
        'price_unit',
        'price_notes',
        'avg_rating',
        'review_count',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'working_hours',
        'service_areas',
        'specialties',
        'years_in_business',
        'business_registration_info',
        'attributes',
        'verified',
        'featured',
        'premium',
        'views_count',
        'subscription_status',
        'subscription_expires_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'featured' => 'boolean',
        'premium' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'min_price' => 'float',
        'max_price' => 'float',
        'avg_rating' => 'float',
        'review_count' => 'integer',
        'views_count' => 'integer',
        'years_in_business' => 'integer',
        'attributes' => 'json',
        'working_hours' => 'array',
        'subscription_expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function owningAgency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'owning_agency_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class)
            ->withPivot('status', 'notes', 'is_preferred', 'terms_and_conditions', 'commission_rate', 'visible_on_agency_profile', 'approved_at', 'rejected_at')
            ->withTimestamps();
    }

    public function approvedAgencies(): BelongsToMany
    {
        return $this->agencies()->wherePivot('status', 'approved');
    }

    public function pendingAgencies(): BelongsToMany
    {
        return $this->agencies()->wherePivot('status', 'pending');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(VendorAvailability::class);
    }

    public function portfolioImages(): MorphMany
    {
        return $this->morphMany(PortfolioImage::class, 'imageable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function packages(): MorphMany
    {
        return $this->morphMany(Package::class, 'packageable');
    }

    public function faqs(): MorphMany
    {
        return $this->morphMany(Faq::class, 'faqable');
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function eventTypes(): BelongsToMany
    {
        return $this->belongsToMany(EventType::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();

        $this->addMediaCollection('banner')
            ->singleFile();

        $this->addMediaCollection('portfolio');

        $this->addMediaCollection('gallery');

        $this->addMediaCollection('documents');
    }

    public function incrementViewsCount()
    {
        $this->increment('views_count');

        return $this;
    }

    public function updateRatingStats()
    {
        $this->avg_rating = $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $this->review_count = $this->reviews()->where('is_approved', true)->count();
        $this->save();

        return $this;
    }

    public function isAvailableOn($date)
    {
        $availability = $this->availabilities()->where('date', $date)->first();

        if (! $availability) {
            return true; // Default to available if no record exists
        }

        return $availability->status === 'available' || $availability->status === 'partially_booked';
    }
}
