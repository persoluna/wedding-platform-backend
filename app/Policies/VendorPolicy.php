<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
{
    use HandlesAuthorization;

    public function before(User $authUser): ?bool
    {
        if ($authUser->hasRole('super_admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $authUser): bool
    {
        if (! $authUser->isAdmin() && ! $authUser->isAgency() && ! $authUser->isVendor()) {
            return false;
        }

        return $authUser->can('ViewAny:Vendor');
    }

    public function view(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('View:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function create(User $authUser): bool
    {
        if (! $authUser->isAdmin() && ! $authUser->isAgency()) {
            return false;
        }

        return $authUser->can('Create:Vendor');
    }

    public function update(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('Update:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function delete(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('Delete:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function restore(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('Restore:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function forceDelete(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('ForceDelete:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('ForceDeleteAny:Vendor');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('RestoreAny:Vendor');
    }

    public function replicate(User $authUser, Vendor $vendor): bool
    {
        return $authUser->can('Replicate:Vendor')
            && $this->canAccessVendor($authUser, $vendor);
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('Reorder:Vendor');
    }

    private function canAccessVendor(User $authUser, Vendor $vendor): bool
    {
        if ($authUser->isVendor()) {
            return (int) $vendor->user_id === (int) $authUser->id;
        }

        if ($authUser->isAgency()) {
            $agency = $authUser->agency;

            if (! $agency) {
                return false;
            }

            if ((int) $vendor->owning_agency_id === (int) $agency->getKey()) {
                return true;
            }

            return $agency->vendors()->whereKey($vendor->getKey())->exists();
        }

        return $authUser->isAdmin();
    }
}
