<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\AdminStatsOverview;
use App\Filament\Admin\Widgets\InquiriesTrendChart;
use App\Filament\Admin\Widgets\RecentInquiriesTable;
use App\Filament\Admin\Widgets\TopMarketsChart;
use BackedEnum;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Dashboard
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $title = 'Super admin dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AdminStatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            InquiriesTrendChart::class,
            TopMarketsChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RecentInquiriesTable::class,
        ];
    }
}
