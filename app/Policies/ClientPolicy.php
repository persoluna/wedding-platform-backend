<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
        if (! $authUser->isAdmin()) {
            return false;
        }

        return $authUser->can('ViewAny:Client');
    }

    public function view(User $authUser, Client $client): bool
    {
        return $authUser->can('View:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function create(User $authUser): bool
    {
        if (! $authUser->isAdmin()) {
            return false;
        }

        return $authUser->can('Create:Client');
    }

    public function update(User $authUser, Client $client): bool
    {
        return $authUser->can('Update:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function delete(User $authUser, Client $client): bool
    {
        return $authUser->can('Delete:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function restore(User $authUser, Client $client): bool
    {
        return $authUser->can('Restore:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function forceDelete(User $authUser, Client $client): bool
    {
        return $authUser->can('ForceDelete:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('ForceDeleteAny:Client');
    }

    public function restoreAny(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('RestoreAny:Client');
    }

    public function replicate(User $authUser, Client $client): bool
    {
        return $authUser->can('Replicate:Client')
            && $this->canAccessClient($authUser, $client);
    }

    public function reorder(User $authUser): bool
    {
        return $authUser->isAdmin()
            && $authUser->can('Reorder:Client');
    }

    private function canAccessClient(User $authUser, Client $client): bool
    {
        if ($authUser->isClient()) {
            return (int) $client->user_id === (int) $authUser->id;
        }

        return $authUser->isAdmin();
    }
}
