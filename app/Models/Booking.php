<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'bookable_id',
        'bookable_type',
        'inquiry_id',
        'event_date',
        'event_location',
        'start_time',
        'end_time',
        'amount',
        'deposit_amount',
        'balance_amount',
        'status',
        'notes',
        'client_notes',
        'vendor_notes',
        'terms_and_conditions',
        'deposit_paid_at',
        'full_payment_received_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'amount' => 'float',
        'deposit_amount' => 'float',
        'balance_amount' => 'float',
        'deposit_paid_at' => 'datetime',
        'full_payment_received_at' => 'datetime',
    ];

    /**
     * Get the client that made the booking.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the parent bookable model (agency or vendor).
     */
    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the inquiry that led to this booking.
     */
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    /**
     * Mark the booking as confirmed.
     */
    public function confirm(): self
    {
        $this->status = 'confirmed';
        $this->save();

        return $this;
    }

    /**
     * Mark the booking as cancelled.
     */
    public function cancel(): self
    {
        $this->status = 'cancelled';
        $this->save();

        return $this;
    }

    /**
     * Mark the booking as completed.
     */
    public function complete(): self
    {
        $this->status = 'completed';
        $this->save();

        return $this;
    }

    /**
     * Check if the deposit has been paid.
     */
    public function isDepositPaid(): bool
    {
        return $this->deposit_paid_at !== null;
    }

    /**
     * Check if the booking is fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->full_payment_received_at !== null;
    }

    /**
     * Get the formatted total amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₹'.number_format($this->amount, 2);
    }

    /**
     * Get the formatted deposit amount.
     */
    public function getFormattedDepositAmountAttribute(): ?string
    {
        if ($this->deposit_amount === null) {
            return null;
        }

        return '₹'.number_format($this->deposit_amount, 2);
    }

    /**
     * Get the formatted balance amount.
     */
    public function getFormattedBalanceAmountAttribute(): ?string
    {
        if ($this->balance_amount === null) {
            return null;
        }

        return '₹'.number_format($this->balance_amount, 2);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }
}
