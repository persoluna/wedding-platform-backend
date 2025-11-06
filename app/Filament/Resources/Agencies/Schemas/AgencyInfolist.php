<?php

namespace App\Filament\Resources\Agencies\Schemas;

use App\Models\Agency;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AgencyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('business_name'),
                TextEntry::make('slug'),
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
                TextEntry::make('avg_rating')
                    ->numeric(),
                TextEntry::make('review_count')
                    ->numeric(),
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
                TextEntry::make('working_hours')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('specialties')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('years_in_business')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('business_registration_info')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (Agency $record): bool => $record->trashed()),
            ]);
    }
}
