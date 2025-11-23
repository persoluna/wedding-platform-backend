<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('avatar')
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('google_id')
                    ->searchable(),
                TextColumn::make('login_type')
                    ->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (User $record) => Auth::user()?->isAdmin()
                        && ! $record->trashed()
                        && ! UsersTable::hasBlockingDependencies($record))
                    ->requiresConfirmation()
                    ->modalDescription(fn (User $record) => UsersTable::getDeleteModalDescription($record))
                    ->before(fn (DeleteAction $action, User $record) => UsersTable::abortIfLinked($action, $record)),
                RestoreAction::make()
                    ->visible(fn ($record) => Auth::user()?->isAdmin() && $record->trashed()),
                ForceDeleteAction::make()
                    ->visible(fn (User $record) => Auth::user()?->isAdmin()
                        && $record->trashed()
                        && ! UsersTable::hasBlockingDependencies($record))
                    ->requiresConfirmation()
                    ->modalDescription(fn (User $record) => UsersTable::getForceDeleteModalDescription($record))
                    ->before(fn (ForceDeleteAction $action, User $record) => UsersTable::abortIfLinked($action, $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    protected static function abortIfLinked(DeleteAction|ForceDeleteAction $action, User $record): void
    {
        $message = static::getBlockingMessage($record);

        if (! $message) {
            return;
        }

        $action->cancel();

        Notification::make()
            ->title('Cannot delete user')
            ->body($message)
            ->warning()
            ->persistent()
            ->send();
    }

    protected static function getDeleteModalDescription(User $record): string
    {
        return static::getBlockingMessage($record)
            ?? 'This will move the user to the trash. They won\'t be able to sign in until restored.';
    }

    protected static function getForceDeleteModalDescription(User $record): string
    {
        return static::getBlockingMessage($record)
            ?? 'This permanently removes the user and all of their related data. This action cannot be undone.';
    }

    protected static function getBlockingMessage(User $record): ?string
    {
        $links = [];

        if ($vendor = $record->vendor()->withTrashed()->first()) {
            $links[] = sprintf('vendor "%s"', $vendor->business_name ?? $vendor->getKey());
        }

        if ($agency = $record->agency()->withTrashed()->first()) {
            $links[] = sprintf('agency "%s"', $agency->business_name ?? $agency->getKey());
        }

        if ($client = $record->client()->withTrashed()->first()) {
            $links[] = sprintf('client "%s"', $client->user->name ?? $client->getKey());
        }

        if ($links === []) {
            return null;
        }

        return 'This user is still linked to ' . implode(', ', $links) . '. Please remove or reassign these records before deleting the user.';
    }

    protected static function hasBlockingDependencies(User $record): bool
    {
        return (bool) static::getBlockingMessage($record);
    }
}
