<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Agency;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Str;

class TopMarketsChart extends BarChartWidget
{
    protected ?string $heading = 'Top cities by demand';

    protected ?string $maxHeight = '240px';

    public ?string $filter = 'city';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getFilters(): ?array
    {
        return [
            'city' => 'By city',
            'state' => 'By state',
            'country' => 'By country',
        ];
    }

    protected function getData(): array
    {
        $groupBy = match ($this->filter) {
            'state' => 'state',
            'country' => 'country',
            default => 'city',
        };

        $results = Agency::query()
            ->whereNotNull($groupBy)
            ->selectRaw("{$groupBy} as location, COUNT(*) as aggregate")
            ->groupBy('location')
            ->orderByDesc('aggregate')
            ->limit(8)
            ->pluck('aggregate', 'location');

        $labels = $results->keys()->map(fn ($value) => Str::title((string) $value))->all();
        $data = $results->values()->all();

        if (empty($labels)) {
            $labels = ['N/A'];
            $data = [0];
        }

        $palette = [
            '#f59e0b',
            '#f472b6',
            '#14b8a6',
            '#6366f1',
            '#22d3ee',
            '#84cc16',
            '#fb7185',
            '#a855f7',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Inquiries',
                    'data' => $data,
                    'backgroundColor' => $palette,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
