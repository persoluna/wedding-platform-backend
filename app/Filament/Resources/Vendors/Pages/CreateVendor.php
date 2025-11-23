<?php

namespace App\Filament\Resources\Vendors\Pages;

use App\Filament\Resources\Vendors\VendorResource;
use App\Models\User;
use App\Models\Vendor;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateVendor extends CreateRecord
{
    protected static string $resource = VendorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $password = $data['vendor_password'] ?? null;

        unset($data['vendor_password'], $data['vendor_password_confirmation']);

        if (! isset($data['created_by_user_id'])) {
            $data['created_by_user_id'] = $user?->id;
        }

        if ($user?->isAdmin()) {
            $this->assertVendorUserAvailable($data['user_id'] ?? null);
        }

        if ($user?->isAgency()) {
            $owningAgencyId = optional($user->agency)->getKey();

            if (! $owningAgencyId) {
                throw ValidationException::withMessages([
                    'owning_agency_id' => 'You must belong to an agency to create vendors.',
                ]);
            }

            $data['owning_agency_id'] = $owningAgencyId;

            if (empty($data['user_id'])) {
                $data['user_id'] = $this->findOrCreateVendorUser($data, $password);
            }
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

    protected function findOrCreateVendorUser(array $data, ?string $password): int
    {
        $email = trim((string) ($data['email'] ?? ''));

        if ($email === '') {
            throw ValidationException::withMessages([
                'email' => 'Please provide an email address for this vendor.',
            ]);
        }

        $existingUser = User::withTrashed()->where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                throw ValidationException::withMessages([
                    'email' => 'This email belongs to an inactive account. Ask an admin to restore or permanently delete it before reusing.',
                ]);
            }

            if (! $existingUser->isVendor()) {
                throw ValidationException::withMessages([
                    'email' => 'This email is already used by another account type.',
                ]);
            }

            $this->ensureVendorRole($existingUser);

            return $existingUser->getKey();
        }

        if ($password === null || $password === '') {
            throw ValidationException::withMessages([
                'vendor_password' => 'Please set a password for the vendor account.',
            ]);
        }

        $user = User::create([
            'name' => $data['business_name'] ?? $email,
            'email' => $email,
            'password' => Hash::make($password),
            'type' => 'vendor',
            'active' => true,
            'phone' => $data['phone'] ?? null,
        ]);

        $this->ensureVendorRole($user);

        return $user->getKey();
    }

    protected function ensureVendorRole(User $user): void
    {
        if ($user->type !== 'vendor') {
            $user->forceFill(['type' => 'vendor'])->save();
        }

        if (! $user->hasRole('vendor')) {
            $user->assignRole('vendor');
        }
    }
}
