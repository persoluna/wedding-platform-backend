<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Agency extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
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
        'avg_rating',
        'review_count',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'working_hours',
        'specialties',
        'years_in_business',
        'business_registration_info',
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
        'avg_rating' => 'float',
        'review_count' => 'integer',
        'views_count' => 'integer',
        'years_in_business' => 'integer',
        'subscription_expires_at' => 'datetime',
        'working_hours' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class)
            ->withPivot('status', 'notes', 'is_preferred', 'terms_and_conditions', 'commission_rate', 'visible_on_agency_profile', 'approved_at', 'rejected_at')
            ->withTimestamps();
    }

    public function ownedVendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'owning_agency_id');
    }

    public function approvedVendors(): BelongsToMany
    {
        return $this->vendors()->wherePivot('status', 'approved');
    }

    public function pendingVendors(): BelongsToMany
    {
        return $this->vendors()->wherePivot('status', 'pending');
    }

    public function rejectedVendors(): BelongsToMany
    {
        return $this->vendors()->wherePivot('status', 'rejected');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
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

    protected static function booted(): void
    {
        static::deleted(fn (Agency $agency) => $agency->deleteUploads());
        static::forceDeleted(fn (Agency $agency) => $agency->deleteUploads());
    }

    protected function deleteUploads(): void
    {
        foreach (['logo', 'banner'] as $attribute) {
            $this->deleteUploadPath($this->{$attribute});
        }
    }

    protected function deleteUploadPath(?string $path): void
    {
        if (! $path) {
            return;
        }

        collect(['public', config('filesystems.default')])
            ->filter()
            ->unique()
            ->each(function (string $disk) use ($path): void {
                try {
                    if (Storage::disk($disk)->exists($path)) {
                        Storage::disk($disk)->delete($path);
                    }
                } catch (\Throwable $exception) {
                    // Ignore disk misconfiguration and continue
                }
            });
    }
}
