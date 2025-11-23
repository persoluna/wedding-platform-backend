<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Agency */
class AgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'specialties' => $this->specialties,
            'years_in_business' => $this->years_in_business,
            'location' => [
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'contact' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'website' => $this->website,
                'whatsapp' => $this->whatsapp,
            ],
            'social' => [
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
                'linkedin' => $this->linkedin,
                'youtube' => $this->youtube,
            ],
            'stats' => [
                'avg_rating' => $this->avg_rating,
                'review_count' => $this->review_count,
                'views_count' => $this->views_count,
                'verified' => (bool) $this->verified,
                'featured' => (bool) $this->featured,
                'premium' => (bool) $this->premium,
            ],
            'media' => [
                'logo' => $this->getFirstMediaUrl('logo') ?: null,
                'banner' => $this->getFirstMediaUrl('banner') ?: null,
                'gallery' => $this->getMedia('gallery')->map(fn ($media) => $media->getFullUrl()),
            ],
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')),
            'links' => [
                'website' => $this->website,
            ],
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
