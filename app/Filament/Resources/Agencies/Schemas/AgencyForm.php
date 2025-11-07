<?php

namespace App\Filament\Resources\Agencies\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AgencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name', fn ($query) => $query->whereHas('roles', fn ($query) => $query->where('name', 'agency')))
                            ->required(),
                        TextInput::make('business_name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->readOnly(),
                    ]),
                RichEditor::make('description')
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->image(),
                FileUpload::make('banner')
                    ->image(),
                TextInput::make('website')
                    ->url(),
                Textarea::make('address')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('city'),
                        TextInput::make('state'),
                        TextInput::make('postal_code'),
                    ]),
                TextInput::make('country')
                    ->required()
                    ->default('India'),
                Grid::make(2)
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric(),
                        TextInput::make('longitude')
                            ->numeric(),
                    ]),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('whatsapp'),
                Grid::make(2)
                    ->schema([
                        TextInput::make('avg_rating')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('review_count')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('facebook'),
                        TextInput::make('instagram'),
                        TextInput::make('twitter'),
                        TextInput::make('linkedin'),
                        TextInput::make('youtube'),
                    ]),
                Textarea::make('working_hours')
                    ->columnSpanFull(),
                Textarea::make('specialties')
                    ->columnSpanFull(),
                TextInput::make('years_in_business')
                    ->numeric(),
                Textarea::make('business_registration_info')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        Toggle::make('verified')
                            ->required(),
                        Toggle::make('featured')
                            ->required(),
                        Toggle::make('premium')
                            ->required(),
                    ]),
                TextInput::make('views_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('subscription_status')
                    ->required()
                    ->default('free'),
                DateTimePicker::make('subscription_expires_at'),
            ]);
    }
}
