<?php

namespace App\Filament\Agency\Pages;

use App\Filament\Agency\Widgets\AgencyStatsOverview;
use App\Filament\Agency\Widgets\LatestAgencyInquiries;
use BackedEnum;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;

class AgencyDashboard extends Dashboard
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Agency dashboard';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user?->isAgency() ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AgencyStatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            LatestAgencyInquiries::class,
        ];
    }

    public function getWidgets(): array
    {
        return [];
    }
}
