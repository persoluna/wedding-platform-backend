<?php

namespace App\Filament\Resources\Inquiries;

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Schemas\InquiryForm;
use App\Filament\Resources\Inquiries\Tables\InquiriesTable;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static UnitEnum|string|null $navigationGroup = 'Customer Pipeline';

    protected static ?int $navigationSort = 40;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InquiryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InquiriesTable::configure($table);
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
            'index' => ListInquiries::route('/'),
            'create' => CreateInquiry::route('/create'),
            'edit' => EditInquiry::route('/{record}/edit'),
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

        if ($user->isAgency()) {
            $agencyId = optional($user->agency)->getKey();

            if (! $agencyId) {
                return $query->whereKey(-1);
            }

            return $query->where('inquiries.agency_id', $agencyId);
        }

        if ($user->isVendor()) {
            $vendorId = optional($user->vendor)->getKey();

            if (! $vendorId) {
                return $query->whereKey(-1);
            }

            return $query->where('inquiries.vendor_id', $vendorId);
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
            'name',
            'email',
            'phone',
            'client.user.name',
            'agency.business_name',
            'vendor.business_name',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Inquiry $record */
        return array_filter([
            'Email' => $record->email,
            'Status' => $record->status ? Str::headline($record->status) : null,
            'Client' => $record->client?->user?->name,
            'Agency' => $record->agency?->business_name,
            'Vendor' => $record->vendor?->business_name,
        ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with([
            'client.user',
            'agency',
            'vendor',
        ]);
    }
}
