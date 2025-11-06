<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'title',
        'description',
        'image_path',
        'thumbnail_path',
        'is_featured',
        'sort_order',
        'metadata',
        'alt_text',
        'tags',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'metadata' => 'json',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFullImageUrlAttribute()
    {
        return asset('storage/'.$this->image_path);
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return asset('storage/'.$this->thumbnail_path);
        }

        return $this->full_image_url;
    }
}
