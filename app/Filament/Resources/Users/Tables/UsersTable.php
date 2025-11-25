<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
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
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
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
                    ->label('User')
                    ->description(fn ($record) => $record->email)
                    ->searchable()
                    ->wrap(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->searchable(),
                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary' => ['admin', 'agency'],
                        'success' => ['vendor', 'client'],
                        'gray' => null,
                    ])
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('email_verified_at')
                    ->label('Verified at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

        return 'This user is still linked to '.implode(', ', $links).'. Please remove or reassign these records before deleting the user.';
    }

    protected static function hasBlockingDependencies(User $record): bool
    {
        return (bool) static::getBlockingMessage($record);
    }
}
