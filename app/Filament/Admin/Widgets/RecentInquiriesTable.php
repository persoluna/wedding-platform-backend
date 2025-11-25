<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentInquiriesTable extends BaseWidget
{
    protected static ?string $heading = 'Latest inquiries';

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '45s';

    protected function getTableQuery(): Builder
    {
        return Inquiry::query()
            ->with(['agency', 'vendor'])
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Client')
                ->searchable()
                ->limit(30),
            Tables\Columns\TextColumn::make('event_location')
                ->label('Event location')
                ->toggleable(),
            Tables\Columns\TextColumn::make('agency.business_name')
                ->label('Agency')
                ->toggleable(),
            Tables\Columns\TextColumn::make('vendor.business_name')
                ->label('Vendor')
                ->toggleable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'new',
                    'info' => 'in_progress',
                    'primary' => 'responded',
                    'success' => 'booked',
                    'danger' => fn ($state) => in_array($state, ['cancelled', 'unavailable']),
                ])
                ->icons([
                    'heroicon-m-sparkles' => 'new',
                    'heroicon-m-arrow-path' => 'in_progress',
                    'heroicon-m-flag' => 'responded',
                    'heroicon-m-check-circle' => 'booked',
                ])
                ->sortable(),
            Tables\Columns\IconColumn::make('is_urgent')
                ->label('Urgent')
                ->boolean(),
            Tables\Columns\TextColumn::make('budget')
                ->money('usd')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'new' => 'New',
                    'in_progress' => 'In progress',
                    'responded' => 'Responded',
                    'booked' => 'Booked',
                    'cancelled' => 'Cancelled',
                    'unavailable' => 'Unavailable',
                ]),
            Tables\Filters\TernaryFilter::make('is_urgent')
                ->label('Urgent only')
                ->trueLabel('Urgent')
                ->falseLabel('Non-urgent'),
            Tables\Filters\Filter::make('recent')
                ->label('Past 7 days')
                ->query(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(7))),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->label('Open')
                ->url(fn (Inquiry $record) => route('filament.admin.resources.inquiries.edit', $record))
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->openUrlInNewTab(),
        ];
    }
}
