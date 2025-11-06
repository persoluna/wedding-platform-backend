<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'parent_id',
        'sort_order',
        'active',
        'is_featured',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    // Get all ancestors
    public function ancestors()
    {
        $ancestors = collect([]);
        $category = $this->parent;

        while ($category) {
            $ancestors->push($category);
            $category = $category->parent;
        }

        return $ancestors->reverse();
    }

    // Get all descendants
    public function descendants()
    {
        $descendants = collect([]);

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants());
        }

        return $descendants;
    }

    // Get breadcrumb path
    public function getBreadcrumbAttribute()
    {
        return $this->ancestors()->push($this)->pluck('name')->implode(' > ');
    }
}
