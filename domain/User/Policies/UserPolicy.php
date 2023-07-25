<?php

namespace Domain\User\Policies;

use Domain\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, User $targetUser): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $targetUser): bool
    {
        return $user->is($targetUser);
    }

    public function delete(User $user, User $targetUser): bool
    {
        return false;
    }

    public function restore(User $user, User $targetUser): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $targetUser): bool
    {
        return false;
    }
}
