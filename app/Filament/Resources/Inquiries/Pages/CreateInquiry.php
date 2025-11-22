<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Filament\Resources\Inquiries\InquiryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInquiry extends CreateRecord
{
    protected static string $resource = InquiryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if ($user && $user->isAgency()) {
            $agencyId = optional($user->agency)->getKey();

            if ($agencyId) {
                $data['agency_id'] = $agencyId;
            }
        }

        return $data;
    }
}
