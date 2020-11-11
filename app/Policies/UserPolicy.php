<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{
    /**
     * Determine whether the user can view the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return mixed
     */
    public function view(User $user, User $targetUser)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return mixed
     */
    public function update(User $user, User $targetUser)
    {
        return $user->is($targetUser);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return mixed
     */
    public function delete(User $user, User $targetUser)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return mixed
     */
    public function restore(User $user, User $targetUser)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $targetUser
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $targetUser)
    {
        return false;
    }
}
