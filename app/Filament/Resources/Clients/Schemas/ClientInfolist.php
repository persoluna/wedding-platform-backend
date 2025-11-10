<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\Client;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('partner_name')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('wedding_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('wedding_city')
                    ->placeholder('-'),
                TextEntry::make('wedding_state')
                    ->placeholder('-'),
                TextEntry::make('wedding_venue')
                    ->placeholder('-'),
                TextEntry::make('guest_count')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('budget')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('wedding_type')
                    ->placeholder('-'),
                TextEntry::make('planning_status')
                    ->placeholder('-'),
                TextEntry::make('preferences')
                    ->columnSpanFull()
                    ->placeholder('-')
                    ->formatStateUsing(static function ($state): ?string {
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
                TextEntry::make('cultural_requirements')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('additional_info')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('booked_vendors')
                    ->placeholder('-')
                    ->columnSpanFull()
                    ->formatStateUsing(static function ($state): ?string {
                        if (blank($state)) {
                            return null;
                        }

                        $vendors = is_string($state) ? json_decode($state, true) : $state;

                        if (! is_array($vendors)) {
                            return (string) $state;
                        }

                        return collect($vendors)
                            ->map(function ($item, $index) {
                                if (! is_array($item)) {
                                    return is_string($item) ? $item : json_encode($item);
                                }

                                $parts = [
                                    isset($item['vendor_id']) ? 'Vendor ID: '.$item['vendor_id'] : null,
                                    isset($item['category']) ? 'Category: '.$item['category'] : null,
                                    isset($item['booking_date']) ? 'Booking date: '.$item['booking_date'] : null,
                                ];

                                $parts = array_filter($parts);

                                return ($index + 1).'. '.implode(', ', $parts);
                            })
                            ->implode(PHP_EOL);
                    }),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Client $record): bool => $record->trashed()),
            ]);
    }
}
