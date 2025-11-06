<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'date',
        'status',
        'notes',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getAvailableFromAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function setAvailableFromAttribute($value)
    {
        $this->attributes['available_from'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function getAvailableToAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function setAvailableToAttribute($value)
    {
        $this->attributes['available_to'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isPartiallyBooked(): bool
    {
        return $this->status === 'partially_booked';
    }

    public function isFullyBooked(): bool
    {
        return $this->status === 'fully_booked';
    }

    public function isUnavailable(): bool
    {
        return $this->status === 'unavailable';
    }

    public function markAsFullyBooked($notes = null)
    {
        $this->status = 'fully_booked';
        if ($notes) {
            $this->notes = $notes;
        }
        $this->save();

        return $this;
    }
}
