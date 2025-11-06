<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'partner_name',
        'wedding_date',
        'wedding_city',
        'wedding_state',
        'wedding_venue',
        'guest_count',
        'budget',
        'wedding_type',
        'preferences',
        'cultural_requirements',
        'phone',
        'additional_info',
        'planning_status',
        'booked_vendors',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'guest_count' => 'integer',
        'budget' => 'float',
        'preferences' => 'array',
        'booked_vendors' => 'json',
        'cultural_requirements' => 'string',
        'additional_info' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name.($this->partner_name ? ' & '.$this->partner_name : '');
    }

    public function getDaysUntilWeddingAttribute()
    {
        if (! $this->wedding_date) {
            return null;
        }

        return now()->diffInDays($this->wedding_date, false);
    }

    public function getIsWeddingInFutureAttribute()
    {
        if (! $this->wedding_date) {
            return true;
        }

        return $this->wedding_date->isFuture();
    }

    public function addBookedVendor($vendorId, $category = null, $bookingDate = null)
    {
        $booked = $this->booked_vendors ?? [];

        $booked[] = [
            'vendor_id' => $vendorId,
            'category' => $category,
            'booking_date' => $bookingDate,
            'added_at' => now()->toDateTimeString(),
        ];

        $this->booked_vendors = $booked;
        $this->save();

        return $this;
    }
}
