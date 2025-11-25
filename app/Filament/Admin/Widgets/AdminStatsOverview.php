<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Agency;
use App\Models\Inquiry;
use App\Models\Vendor;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = null;

    public ?string $filter = '30_days';

    protected ?string $pollingInterval = '60s';

    protected function getFilters(): ?array
    {
        return [
            '7_days' => 'Last 7 days',
            '30_days' => 'Last 30 days',
            '90_days' => 'Last 90 days',
            '365_days' => 'Last 12 months',
            'all' => 'All time',
        ];
    }

    protected function getStats(): array
    {
        [$start, $end] = $this->getRange();

        $agencies = $this->countFor(Agency::query(), $start, $end);
        $vendors = $this->countFor(Vendor::query(), $start, $end);
        $newInquiries = $this->countFor(Inquiry::query(), $start, $end);
        $bookedInquiries = $this->countFor(
            Inquiry::query()->where('status', 'booked'),
            $start,
            $end,
            dateColumn: 'closed_at'
        );
        $urgentInquiries = $this->countFor(
            Inquiry::query()->where('is_urgent', true),
            $start,
            $end
        );

        return [
            $this->makeStat(
                label: 'Agencies onboarded',
                value: $agencies,
                total: Agency::count(),
                icon: 'heroicon-m-building-office-2',
                chart: $this->chartData(Agency::query(), $start, $end)
            ),
            $this->makeStat(
                label: 'Vendors onboarded',
                value: $vendors,
                total: Vendor::count(),
                icon: 'heroicon-m-briefcase',
                chart: $this->chartData(Vendor::query(), $start, $end)
            ),
            $this->makeStat(
                label: 'New inquiries',
                value: $newInquiries,
                total: Inquiry::count(),
                icon: 'heroicon-m-inbox-stack',
                chart: $this->chartData(Inquiry::query(), $start, $end)
            ),
            $this->makeStat(
                label: 'Confirmed bookings',
                value: $bookedInquiries,
                total: Inquiry::query()->where('status', 'booked')->count(),
                icon: 'heroicon-m-check-badge',
                chart: $this->chartData(
                    Inquiry::query()->where('status', 'booked'),
                    $start,
                    $end,
                    dateColumn: 'closed_at'
                )
            ),
            $this->makeStat(
                label: 'Urgent leads',
                value: $urgentInquiries,
                total: Inquiry::query()->where('is_urgent', true)->count(),
                icon: 'heroicon-m-bolt',
                chart: $this->chartData(
                    Inquiry::query()->where('is_urgent', true),
                    $start,
                    $end
                ),
                color: 'warning'
            ),
        ];
    }

    protected function getRange(): array
    {
        $end = Carbon::now();

        $filter = $this->filter ?? '30_days';

        return match ($filter) {
            '7_days' => [$end->copy()->subDays(6)->startOfDay(), $end],
            '90_days' => [$end->copy()->subDays(89)->startOfDay(), $end],
            '365_days' => [$end->copy()->subDays(364)->startOfDay(), $end],
            'all' => [null, $end],
            default => [$end->copy()->subDays(29)->startOfDay(), $end],
        };
    }

    protected function makeStat(string $label, int $value, int $total, string $icon, array $chart, ?string $color = null): Stat
    {
        return Stat::make($label, number_format($value))
            ->description(match ($this->filter ?? '30_days') {
                'all' => 'Total to date: '.number_format($total),
                default => 'All-time: '.number_format($total),
            })
            ->icon($icon)
            ->color($color ?? 'primary')
            ->chart($chart);
    }

    protected function countFor(Builder $query, ?CarbonInterface $start, CarbonInterface $end, string $dateColumn = 'created_at'): int
    {
        if ($start) {
            $query->whereBetween($dateColumn, [$start, $end]);
        }

        return (int) $query->count();
    }

    protected function chartData(Builder $query, ?CarbonInterface $start, CarbonInterface $end, string $dateColumn = 'created_at'): array
    {
        $chartStart = $start?->copy() ?? $end->copy()->subDays(9)->startOfDay();

        $data = (clone $query)
            ->selectRaw('DATE('.$dateColumn.') as day, COUNT(*) as aggregate')
            ->whereNotNull($dateColumn)
            ->whereBetween($dateColumn, [$chartStart, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('aggregate', 'day');

        $period = CarbonPeriod::create($chartStart, '1 day', $end);

        return collect($period)
            ->map(fn ($date) => (int) ($data[$date->format('Y-m-d')] ?? 0))
            ->values()
            ->all();
    }
}
