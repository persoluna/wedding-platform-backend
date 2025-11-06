<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'price',
        'price_unit',
        'price_notes',
        'is_featured',
        'image',
        'sort_order',
        'attributes',
        'available',
        'duration_minutes',
    ];

    protected $casts = [
        'price' => 'float',
        'is_featured' => 'boolean',
        'available' => 'boolean',
        'sort_order' => 'integer',
        'duration_minutes' => 'integer',
        'attributes' => 'json',
        'description' => 'string',
        'price_notes' => 'string',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getFormattedPriceAttribute()
    {
        if (! $this->price) {
            return 'Price on request';
        }

        return '₹'.number_format($this->price).' '.$this->price_unit;
    }

    public function getFormattedDurationAttribute()
    {
        if (! $this->duration_minutes) {
            return null;
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return $hours.'h '.$minutes.'min';
        } elseif ($hours > 0) {
            return $hours.' hour'.($hours > 1 ? 's' : '');
        } else {
            return $minutes.' minute'.($minutes > 1 ? 's' : '');
        }
    }
}
