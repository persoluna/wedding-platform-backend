<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Client')
                    ->description(fn ($record) => collect([
                        $record->partner_name ? "Partner: {$record->partner_name}" : null,
                        $record->phone,
                    ])->filter()->join(' • '))
                    ->searchable()
                    ->wrap(),
                TextColumn::make('wedding_date')
                    ->label('Wedding date')
                    ->date()
                    ->sortable(),
                TextColumn::make('wedding_city')
                    ->label('City')
                    ->icon('heroicon-o-map-pin')
                    ->searchable(),
                TextColumn::make('guest_count')
                    ->label('Guests')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('budget')
                    ->label('Budget')
                    ->money('INR')
                    ->sortable(),
                BadgeColumn::make('planning_status')
                    ->label('Planning status')
                    ->colors([
                        'gray' => 'researching',
                        'primary' => 'planning',
                        'success' => 'booked',
                        'warning' => 'paused',
                    ])
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && ! $record->trashed()),
                    RestoreAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                    ForceDeleteAction::make()
                        ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->recordActionsPosition(RecordActionsPosition::AfterColumns);
    }
}
