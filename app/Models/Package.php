<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'packageable_id',
        'packageable_type',
        'name',
        'description',
        'price',
        'price_unit',
        'whats_included',
        'terms_and_conditions',
        'image',
        'is_featured',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'price' => 'float',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'active' => 'boolean',
    ];

    public function packageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFormattedPriceAttribute()
    {
        return '₹'.number_format($this->price).' '.$this->price_unit;
    }
}
