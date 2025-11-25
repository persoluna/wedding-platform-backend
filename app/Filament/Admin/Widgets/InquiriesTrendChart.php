<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inquiry;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Collection;

class InquiriesTrendChart extends BarChartWidget
{
    protected ?string $heading = 'Lead flow';

    protected ?string $maxHeight = '220px';

    public ?string $filter = '7_days';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getFilters(): ?array
    {
        return [
            '7_days' => '7 days',
            '14_days' => '14 days',
            '30_days' => '30 days',
        ];
    }

    protected function getData(): array
    {
        [$start, $end] = $this->getRange();

        $dateRange = $this->generateDateLabels($start, $end);
        $labels = $dateRange->map(fn (Carbon $date) => $date->format('M j'));

        $rawCounts = Inquiry::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as aggregate')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('aggregate', 'day');

        $data = $dateRange->map(
            fn (Carbon $date) => (int) ($rawCounts[$date->format('Y-m-d')] ?? 0)
        );

        return [
            'datasets' => [
                [
                    'label' => 'New leads',
                    'data' => $data->all(),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.85)',
                    'hoverBackgroundColor' => '#6366f1',
                    'borderRadius' => 8,
                    'barThickness' => 12,
                ],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getRange(): array
    {
        $end = Carbon::now()->endOfDay();
        $filter = $this->filter ?? '14_days';

        return match ($filter) {
            '7_days' => [$end->copy()->subDays(6)->startOfDay(), $end],
            '30_days' => [$end->copy()->subDays(29)->startOfDay(), $end],
            default => [$end->copy()->subDays(13)->startOfDay(), $end],
        };
    }

    protected function generateDateLabels(Carbon $start, Carbon $end): Collection
    {
        return collect(CarbonPeriod::create($start, '1 day', $end));
    }
}
