<?php

namespace App\Filament\Vendor\Pages;

use App\Filament\Vendor\Widgets\LatestVendorInquiries;
use App\Filament\Vendor\Widgets\VendorStatsOverview;
use BackedEnum;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;

class VendorDashboard extends Dashboard
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Vendor dashboard';

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user?->isVendor() ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VendorStatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            LatestVendorInquiries::class,
        ];
    }

    public function getWidgets(): array
    {
        return [];
    }
}
