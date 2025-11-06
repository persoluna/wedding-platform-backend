<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'reviewable_id',
        'reviewable_type',
        'comment',
        'rating',
        'pros',
        'cons',
        'rating_breakdown',
        'event_date',
        'is_verified_purchase',
        'is_approved',
        'is_featured',
        'admin_notes',
        'vendor_response',
        'vendor_responded_at',
        'is_reported',
        'report_reason',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_reported' => 'boolean',
        'vendor_responded_at' => 'datetime',
        'rating_breakdown' => 'json',
        'event_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFormattedRatingAttribute()
    {
        return $this->rating.'/5';
    }

    public function approve()
    {
        $this->is_approved = true;
        $this->save();

        // Update the vendor or agency rating stats
        if ($this->reviewable) {
            $this->reviewable->updateRatingStats();
        }

        return $this;
    }

    public function addVendorResponse($response)
    {
        $this->vendor_response = $response;
        $this->vendor_responded_at = now();
        $this->save();

        return $this;
    }

    public function report($reason)
    {
        $this->is_reported = true;
        $this->report_reason = $reason;
        $this->save();

        return $this;
    }
}
