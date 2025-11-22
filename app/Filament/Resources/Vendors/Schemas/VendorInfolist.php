<?php

namespace App\Filament\Resources\Vendors\Schemas;

use App\Models\Vendor;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VendorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('category.name')
                    ->label('Category')
                    ->placeholder('-'),
                TextEntry::make('business_name'),
                TextEntry::make('slug'),
                TextEntry::make('owningAgency.business_name')
                    ->label('Owning agency')
                    ->placeholder('-'),
                TextEntry::make('createdBy.name')
                    ->label('Created by')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('banner')
                    ->placeholder('-'),
                TextEntry::make('website')
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('city')
                    ->placeholder('-'),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('postal_code')
                    ->placeholder('-'),
                TextEntry::make('country'),
                TextEntry::make('latitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('whatsapp')
                    ->placeholder('-'),
                TextEntry::make('min_price')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('max_price')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('price_unit')
                    ->placeholder('-'),
                TextEntry::make('price_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('service_areas')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('specialties')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('attributes')
                    ->placeholder('-')
                    ->columnSpanFull()
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        if (is_array($state)) {
                            return collect($state)
                                ->map(fn ($value, $key) => sprintf('%s: %s', $key, $value))
                                ->implode(PHP_EOL);
                        }

                        return (string) $state;
                    }),
                TextEntry::make('working_hours')
                    ->placeholder('-')
                    ->columnSpanFull()
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        if (is_array($state)) {
                            return collect($state)
                                ->map(fn ($value, $key) => is_string($key) ? sprintf('%s: %s', $key, $value) : $value)
                                ->implode(PHP_EOL);
                        }

                        return (string) $state;
                    }),
                TextEntry::make('years_in_business')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('business_registration_info')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('facebook')
                    ->placeholder('-'),
                TextEntry::make('instagram')
                    ->placeholder('-'),
                TextEntry::make('twitter')
                    ->placeholder('-'),
                TextEntry::make('linkedin')
                    ->placeholder('-'),
                TextEntry::make('youtube')
                    ->placeholder('-'),
                TextEntry::make('avg_rating')
                    ->numeric(),
                TextEntry::make('review_count')
                    ->numeric(),
                IconEntry::make('verified')
                    ->boolean(),
                IconEntry::make('featured')
                    ->boolean(),
                IconEntry::make('premium')
                    ->boolean(),
                TextEntry::make('views_count')
                    ->numeric(),
                TextEntry::make('subscription_status'),
                TextEntry::make('subscription_expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Vendor $record): bool => $record->trashed()),
            ]);
    }
}
