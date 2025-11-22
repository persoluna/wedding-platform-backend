<?php

namespace App\Filament\Resources\Vendors\Pages;

use App\Filament\Resources\Vendors\VendorResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateVendor extends CreateRecord
{
    protected static string $resource = VendorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if (! isset($data['created_by_user_id'])) {
            $data['created_by_user_id'] = $user?->id;
        }

        if ($user?->isAgency() && empty($data['owning_agency_id'])) {
            $data['owning_agency_id'] = optional($user->agency)->getKey();
        }

        return $data;
    }
}
