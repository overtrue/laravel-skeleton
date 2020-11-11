<?php

namespace App\Traits;

use App\Models\User;

/**
 * Trait BelongsToUser.
 *
 * @property \App\Models\User $user
 */
trait BelongsToUser
{
    public static function bootBelongsToUser()
    {
        static::saving(function ($model) {
            if (!$model->user_id) {
                $model->user_id = \auth()->id() ?? User::SYSTEM_USER_ID;
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return bool
     */
    public function isOwnedBy($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->user_id == \intval($user);
    }
}
