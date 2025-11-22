<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Select::make('agency_id')
                            ->relationship('agency', 'business_name')
                            ->label('Agency')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn (): ?int => Auth::user()?->agency?->getKey())
                            ->disabled(fn (): bool => Auth::user()?->isAgency() ?? false)
                            ->dehydrated(),
                        Select::make('client_id')
                            ->relationship('client', 'id')
                            ->label('Client')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->user?->name ?? 'Client #'.$record->getKey()),
                        Select::make('vendor_id')
                            ->relationship('vendor', 'business_name', function ($query): void {
                                $user = Auth::user();

                                if ($user && $user->isAgency()) {
                                    $agencyId = optional($user->agency)->getKey();

                                    if ($agencyId) {
                                        $query->where('owning_agency_id', $agencyId);
                                    } else {
                                        $query->whereRaw('1 = 0');
                                    }
                                }
                            })
                            ->label('Vendor')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ]),
                Grid::make(3)
                    ->schema([
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        DatePicker::make('event_date')
                            ->native(false),
                        TextInput::make('event_location')
                            ->maxLength(255),
                    ]),
                Grid::make(3)
                    ->schema([
                        TextInput::make('guest_count')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('budget')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01),
                        Select::make('status')
                            ->options([
                                'new' => 'New',
                                'in_progress' => 'In progress',
                                'responded' => 'Responded',
                                'booked' => 'Booked',
                                'cancelled' => 'Cancelled',
                                'unavailable' => 'Unavailable',
                            ])
                            ->default('new')
                            ->required(),
                    ]),
                Textarea::make('message')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('admin_notes')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('internal_notes')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('client_notes')
                    ->rows(3)
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        Toggle::make('is_urgent')
                            ->label('Urgent?')
                            ->default(false),
                        TextInput::make('source')
                            ->maxLength(255)
                            ->placeholder('e.g., Website, Referral'),
                        DateTimePicker::make('responded_at')
                            ->label('Responded at')
                            ->native(false),
                    ]),
                Grid::make(2)
                    ->schema([
                        DateTimePicker::make('last_follow_up_at')
                            ->label('Last follow-up')
                            ->native(false),
                        DateTimePicker::make('closed_at')
                            ->label('Closed at')
                            ->native(false),
                    ]),
            ]);
    }
}
