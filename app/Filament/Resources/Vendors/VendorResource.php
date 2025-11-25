<?php

namespace App\Filament\Resources\Vendors;

use App\Filament\Resources\Vendors\Pages\CreateVendor;
use App\Filament\Resources\Vendors\Pages\EditVendor;
use App\Filament\Resources\Vendors\Pages\ListVendors;
use App\Filament\Resources\Vendors\Pages\ViewVendor;
use App\Filament\Resources\Vendors\Schemas\VendorForm;
use App\Filament\Resources\Vendors\Schemas\VendorInfolist;
use App\Filament\Resources\Vendors\Tables\VendorsTable;
use App\Models\Vendor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static UnitEnum|string|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'business_name';

    public static function form(Schema $schema): Schema
    {
        return VendorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VendorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VendorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVendors::route('/'),
            'create' => CreateVendor::route('/create'),
            'view' => ViewVendor::route('/{record}'),
            'edit' => EditVendor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        $user = Auth::user();

        if (! $user) {
            return $query->whereKey(-1);
        }

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isVendor()) {
            return $query->where('vendors.user_id', $user->id);
        }

        if ($user->isAgency()) {
            $agency = $user->agency;

            if (! $agency) {
                return $query->whereKey(-1);
            }

            $agencyId = $agency->getKey();

            return $query->where(function (Builder $builder) use ($agencyId): void {
                $builder
                    ->where('vendors.owning_agency_id', $agencyId)
                    ->orWhere(function (Builder $nested) use ($agencyId): void {
                        $nested
                            ->whereNull('vendors.owning_agency_id')
                            ->whereHas('agencies', static function (Builder $relation) use ($agencyId): void {
                                $relation->whereKey($agencyId);
                            });
                    });
            });
        }

        return $query->whereKey(-1);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::getEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'business_name',
            'user.name',
            'user.email',
            'category.name',
            'phone',
            'city',
            'state',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Vendor $record */
        return array_filter([
            'Category' => $record->category?->name,
            'Email' => $record->user?->email ?? $record->email,
            'Phone' => $record->phone,
            'Location' => collect([
                $record->city,
                $record->state,
            ])->filter()->implode(', '),
        ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with([
            'user',
            'category',
        ]);
    }
}
