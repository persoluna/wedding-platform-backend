<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'recipient_id',
        'inquiry_id',
        'message',
        'read_at',
        'is_system_message',
        'attachments',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'is_system_message' => 'boolean',
        'attachments' => 'json',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function markAsRead()
    {
        if (! $this->read_at) {
            $this->read_at = now();
            $this->save();
        }

        return $this;
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
