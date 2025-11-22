<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Inquiry;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AgencyStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $agency = Auth::user()?->agency;

        if (! $agency) {
            return [];
        }

        $ownedVendorCount = $agency->ownedVendors()->count();
        $activeInquiryCount = $agency->inquiries()
            ->whereIn('status', ['new', 'in_progress', 'responded'])
            ->count();
        $bookedCount = $agency->inquiries()->where('status', 'booked')->count();

        return [
            Stat::make('Owned vendors', (string) $ownedVendorCount)
                ->description('Vendors managed directly by your agency')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),
            Stat::make('Active inquiries', (string) $activeInquiryCount)
                ->description('Work that still needs attention')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color('warning'),
            Stat::make('Booked events', (string) $bookedCount)
                ->description('Confirmed bookings via your agency')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
