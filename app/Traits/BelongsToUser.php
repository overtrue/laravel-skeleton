<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Models\User $user
 * @property string           $user_id
 * @method static saving(\Closure $param)
 * @method belongsTo(string $class)
 */
trait BelongsToUser
{
    public static function bootBelongsToUser()
    {
        static::saving(
            function (Model $model) {
                if (!$model->user_id) {
                    $model->user_id = \auth()->id() ?? User::SYSTEM_USER_ID;
                }
            }
        );
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function isOwnedBy(User|int $user): bool
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->user_id == \intval($user);
    }
}
