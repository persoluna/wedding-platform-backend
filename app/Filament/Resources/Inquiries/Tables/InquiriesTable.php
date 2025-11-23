<?php

namespace App\Filament\Resources\Inquiries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Client name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('agency.business_name')
                    ->label('Agency')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('vendor.business_name')
                    ->label('Vendor')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('budget')
                    ->money('INR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'new',
                        'info' => 'in_progress',
                        'success' => 'booked',
                        'primary' => 'responded',
                        'danger' => fn ($state) => in_array($state, ['cancelled', 'unavailable']),
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'new',
                        'heroicon-o-arrow-path' => 'in_progress',
                        'heroicon-o-check-circle' => 'booked',
                        'heroicon-o-envelope-open' => 'responded',
                        'heroicon-o-x-circle' => ['cancelled', 'unavailable'],
                    ])
                    ->sortable(),
                IconColumn::make('is_urgent')
                    ->boolean()
                    ->label('Urgent'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In progress',
                        'responded' => 'Responded',
                        'booked' => 'Booked',
                        'cancelled' => 'Cancelled',
                        'unavailable' => 'Unavailable',
                    ]),
                TernaryFilter::make('is_urgent')
                    ->label('Urgent only'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()?->isAdmin() && ! $record->trashed()),
                RestoreAction::make()
                    ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                ForceDeleteAction::make()
                    ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
