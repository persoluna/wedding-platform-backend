<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
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
        if (! $authUser->isAdmin() && ! $authUser->isAgency()) {
            return false;
        }

        return $authUser->can('ViewAny:Agency');
    }

    public function view(User $authUser, Agency $agency): bool
    {
        return $authUser->can('View:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function create(User $authUser): bool
    {
        if (! $authUser->isAdmin() && ! $authUser->isAgency()) {
            return false;
        }

        return $authUser->can('Create:Agency');
    }

    public function update(User $authUser, Agency $agency): bool
    {
        return $authUser->can('Update:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function delete(User $authUser, Agency $agency): bool
    {
        return $authUser->can('Delete:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function restore(User $authUser, Agency $agency): bool
    {
        return $authUser->can('Restore:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function forceDelete(User $authUser, Agency $agency): bool
    {
        return $authUser->can('ForceDelete:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('ForceDeleteAny:Agency');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('RestoreAny:Agency');
    }

    public function replicate(User $authUser, Agency $agency): bool
    {
        return $authUser->can('Replicate:Agency')
            && $this->canAccessAgency($authUser, $agency);
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('Reorder:Agency');
    }

    private function canAccessAgency(User $authUser, Agency $agency): bool
    {
        if ($authUser->isAgency()) {
            return (int) $agency->user_id === (int) $authUser->id;
        }

        return true;
    }
}
