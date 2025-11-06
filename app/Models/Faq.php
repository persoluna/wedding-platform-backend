<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'faqable_id',
        'faqable_type',
        'question',
        'answer',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'active' => 'boolean',
    ];

    public function faqable(): MorphTo
    {
        return $this->morphTo();
    }
}
