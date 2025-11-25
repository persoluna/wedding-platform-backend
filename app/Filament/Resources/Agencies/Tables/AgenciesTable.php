<?php

namespace App\Filament\Resources\Agencies\Tables;

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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AgenciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('business_name')
                    ->label('Agency')
                    ->weight('medium')
                    ->description(fn ($record) => $record->website)
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->state(fn ($record) => collect([$record->city, $record->state])->filter()->join(', '))
                    ->icon('heroicon-o-map-pin')
                    ->wrap(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('avg_rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => filled($state) ? number_format($state, 1) : '—')
                    ->suffix(' / 5')
                    ->sortable(),
                TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('subscription_status')
                    ->label('Subscription')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'expiring',
                        'danger' => 'expired',
                        'gray' => null,
                    ])
                    ->icons([
                        'heroicon-o-bolt' => 'active',
                        'heroicon-o-clock' => 'expiring',
                        'heroicon-o-x-circle' => 'expired',
                    ])
                    ->placeholder('—'),
                TextColumn::make('subscription_expires_at')
                    ->label('Renews')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('verified')
                    ->label('Verified')
                    ->boolean(),
                IconColumn::make('premium')
                    ->label('Premium')
                    ->boolean(),
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
