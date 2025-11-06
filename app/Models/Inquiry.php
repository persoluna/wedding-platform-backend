<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'agency_id',
        'vendor_id',
        'name',
        'email',
        'phone',
        'event_date',
        'event_location',
        'guest_count',
        'message',
        'budget',
        'status',
        'admin_notes',
        'internal_notes',
        'client_notes',
        'is_urgent',
        'source',
        'responded_at',
        'last_follow_up_at',
        'closed_at',
    ];

    protected $casts = [
        'event_date' => 'date',
        'guest_count' => 'integer',
        'budget' => 'float',
        'is_urgent' => 'boolean',
        'responded_at' => 'datetime',
        'last_follow_up_at' => 'datetime',
        'closed_at' => 'datetime',
        'message' => 'string',
        'admin_notes' => 'string',
        'internal_notes' => 'string',
        'client_notes' => 'string',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function markAsResponded()
    {
        $this->status = 'responded';
        $this->responded_at = now();
        $this->save();

        return $this;
    }

    public function recordFollowUp()
    {
        $this->last_follow_up_at = now();
        $this->save();

        return $this;
    }

    public function close($status = 'booked')
    {
        $this->status = $status;
        $this->closed_at = now();
        $this->save();

        return $this;
    }

    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    public function isResponded(): bool
    {
        return $this->status === 'responded';
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function isClosed(): bool
    {
        return in_array($this->status, ['booked', 'cancelled', 'unavailable']);
    }

    public function getDaysSinceCreationAttribute()
    {
        return $this->created_at->diffInDays(now());
    }
}
