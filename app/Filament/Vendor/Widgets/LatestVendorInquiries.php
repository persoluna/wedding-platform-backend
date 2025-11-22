<?php

namespace App\Filament\Vendor\Widgets;

use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

class LatestVendorInquiries extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getTableQuery(): Builder|Relation|null
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor) {
            return Inquiry::query()->whereKey(-1);
        }

        return Inquiry::query()
            ->where('vendor_id', $vendor->getKey())
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Client')
                ->limit(30)
                ->searchable(),
            Tables\Columns\TextColumn::make('agency.business_name')
                ->label('Agency')
                ->limit(30)
                ->searchable(),
            Tables\Columns\TextColumn::make('event_date')
                ->date()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'new',
                    'info' => 'in_progress',
                    'primary' => 'responded',
                    'success' => 'booked',
                    'danger' => fn ($state) => in_array($state, ['cancelled', 'unavailable']),
                ]),
            Tables\Columns\IconColumn::make('is_urgent')
                ->label('Urgent')
                ->boolean(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated')
                ->dateTime()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->label('Open')
                ->url(fn (Inquiry $record) => route('filament.vendor.resources.inquiries.edit', $record))
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->openUrlInNewTab(),
        ];
    }

    protected function getTableHeading(): string
    {
        return 'Recent inquiries';
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
