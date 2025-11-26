<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\Vendor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name', fn ($query) => $query->where('type', 'client'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('partner_name')
                            ->maxLength(255),
                        DatePicker::make('wedding_date')
                            ->native(false),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('wedding_city')
                            ->maxLength(255),
                        TextInput::make('wedding_state')
                            ->maxLength(255),
                    ]),
                TextInput::make('wedding_venue')
                    ->maxLength(255),
                Grid::make(3)
                    ->schema([
                        TextInput::make('guest_count')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('budget')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->prefix('₹'),
                        TextInput::make('wedding_type')
                            ->maxLength(255),
                    ]),
                Select::make('planning_status')
                    ->options([
                        'just_engaged' => 'Just engaged',
                        'planning' => 'Planning',
                        'finalizing' => 'Finalizing',
                        'completed' => 'Completed',
                    ])
                    ->default('just_engaged')
                    ->required(),
                KeyValue::make('preferences')
                    ->columnSpanFull()
                    ->keyLabel('Preference')
                    ->valueLabel('Details')
                    ->addButtonLabel('Add preference')
                    ->nullable(),
                Textarea::make('cultural_requirements')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('additional_info')
                    ->rows(4)
                    ->columnSpanFull(),
                Repeater::make('booked_vendors')
                    ->columnSpanFull()
                    ->default([])
                    ->schema([
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->options(fn () => Vendor::query()->orderBy('business_name')->pluck('business_name', 'id')->all())
                            ->searchable()
                            ->preload(),
                        TextInput::make('category')
                            ->maxLength(255),
                        DatePicker::make('booking_date')
                            ->native(false),
                    ])
                    ->addActionLabel('Add booked vendor'),
            ]);
    }
}
