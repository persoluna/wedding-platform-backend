<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The vendors that cater to this event type.
     */
    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'event_type_vendor');
    }

    /**
     * Scope a query to only include active event types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
