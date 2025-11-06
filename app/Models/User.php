<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone',
        'avatar',
        'active',
        'google_id',
        'login_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->type === 'admin';
        }

        if ($panel->getId() === 'agency') {
            return $this->type === 'agency' && $this->active;
        }

        if ($panel->getId() === 'vendor') {
            return $this->type === 'vendor' && $this->active;
        }

        return false;
    }

    public function agency()
    {
        return $this->hasOne(Agency::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isAgency(): bool
    {
        return $this->type === 'agency';
    }

    public function isVendor(): bool
    {
        return $this->type === 'vendor';
    }

    public function isClient(): bool
    {
        return $this->type === 'client';
    }
}
