<?php

namespace App\Filament\Resources\Vendors\Pages;

use App\Filament\Resources\Vendors\VendorResource;
use App\Models\Vendor;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EditVendor extends EditRecord
{
    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = Auth::user();

        if ($user?->isAgency()) {
            $data['owning_agency_id'] = optional($user->agency)->getKey();
        }

        if ($user?->isAdmin()) {
            $this->assertVendorUserAvailable($data['user_id'] ?? null, $this->record->getKey());
        }

        return $data;
    }

    protected function assertVendorUserAvailable(?int $userId, ?int $ignoreVendorId = null): void
    {
        if (! $userId) {
            return;
        }

        $query = Vendor::withTrashed()->where('user_id', $userId);

        if ($ignoreVendorId) {
            $query->whereKeyNot($ignoreVendorId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'user_id' => 'This vendor user is already linked to another vendor record.',
            ]);
        }
    }
}
