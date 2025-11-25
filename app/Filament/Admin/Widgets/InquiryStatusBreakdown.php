<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Inquiry;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class InquiryStatusBreakdown extends ChartWidget
{
    protected ?string $heading = 'Pipeline mix';

    protected ?string $maxHeight = '220px';

    public ?string $filter = '30_days';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getFilters(): ?array
    {
        return [
            '30_days' => '30 days',
            '90_days' => '90 days',
            '365_days' => '12 months',
            'all' => 'All time',
        ];
    }

    protected function getData(): array
    {
        [$start, $end] = $this->getRange();

        $query = Inquiry::query();

        if ($start) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $results = $query
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($this->statusLabels() as $status => $label) {
            $count = (int) ($results[$status] ?? 0);

            if ($count === 0) {
                continue;
            }

            $labels[] = $label;
            $data[] = $count;
            $colors[] = $this->statusColors()[$status] ?? '#94a3b8';
        }

        if (empty($data)) {
            $labels = ['No data'];
            $data = [1];
            $colors = ['#e5e7eb'];
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4,
                    'borderWidth' => 2,
                    'borderColor' => '#0f172a',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getRange(): array
    {
        $end = Carbon::now()->endOfDay();

        $filter = $this->filter ?? '30_days';

        return match ($filter) {
            '90_days' => [$end->copy()->subDays(89)->startOfDay(), $end],
            '365_days' => [$end->copy()->subDays(364)->startOfDay(), $end],
            'all' => [null, $end],
            default => [$end->copy()->subDays(29)->startOfDay(), $end],
        };
    }

    protected function statusLabels(): array
    {
        return [
            'new' => 'New',
            'in_progress' => 'In progress',
            'responded' => 'Responded',
            'booked' => 'Booked',
            'cancelled' => 'Cancelled',
            'unavailable' => 'Unavailable',
        ];
    }

    protected function statusColors(): array
    {
        return [
            'new' => '#f97316',
            'in_progress' => '#3b82f6',
            'responded' => '#0d9488',
            'booked' => '#6366f1',
            'cancelled' => '#ef4444',
            'unavailable' => '#94a3b8',
        ];
    }
}
