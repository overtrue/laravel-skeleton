<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{
    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Models\User       $targetUser
     *
     * @return bool
     */
    public function view(?User $user, User $targetUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param \App\Models\User $user
     *
     * @return false
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return bool
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->is($targetUser);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return false
     */
    public function delete(User $user, User $targetUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return false
     */
    public function restore(User $user, User $targetUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return false
     */
    public function forceDelete(User $user, User $targetUser): bool
    {
        return false;
    }
}
