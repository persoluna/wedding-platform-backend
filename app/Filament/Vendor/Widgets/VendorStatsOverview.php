<?php

namespace App\Filament\Vendor\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class VendorStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor) {
            return [];
        }

        $totalInquiries = $vendor->inquiries()->count();
        $activeInquiries = $vendor->inquiries()
            ->whereIn('status', ['new', 'in_progress', 'responded'])
            ->count();
        $bookedInquiries = $vendor->inquiries()->where('status', 'booked')->count();
        $urgentInquiries = $vendor->inquiries()->where('is_urgent', true)->count();

        return [
            Stat::make('Total inquiries', (string) $totalInquiries)
                ->description('All time interest in your services')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color('primary'),
            Stat::make('Active pipeline', (string) $activeInquiries)
                ->description('New, in progress, or responded')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
            Stat::make('Booked events', (string) $bookedInquiries)
                ->description('Confirmed and closed deals')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Urgent leads', (string) $urgentInquiries)
                ->description('Needs quick attention')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('danger'),
        ];
    }
}
