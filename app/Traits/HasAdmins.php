<?php

namespace App\Traits;

use App\Pivots\MorphPivotWithCreator;
use App\Models\User;

/**
 * Trait HasAdmins.
 *
 * @property \Illuminate\Database\Eloquent\Collection $admins
 */
trait HasAdmins
{
    public static function bootHasAdmins()
    {
        static::saved(function ($model) {
            /* @var  $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasAdmins */
            if ((!\app()->runningInConsole() || \app()->runningUnitTests()) && \request()->has('admins')) {
                $model->admins()->sync(self::resolveAdminIds(\request()->get('admins', [])));
            }
        });

        static::created(function ($model) {
            /* @var  $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasAdmins */
            if (\Auth::check()) {
                $model->addAdmin(\Auth::id());
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function admins()
    {
        return $this->morphToMany(User::class, 'adminable')
            ->using(MorphPivotWithCreator::class)
            ->withTimestamps()
            ->withTrashed()
            ->withPivot('creator_id')
            ->wherePivot('user_id', '<>', User::SYSTEM_USER_ID);
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return array
     */
    public function addAdmin($user)
    {
        return $this->admins()->syncWithoutDetaching($user);
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return int
     */
    public function removeAdmin($user)
    {
        return $this->admins()->detach($user);
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return bool
     */
    public function hasAdmin($user)
    {
        return $this->isManagedBy($user);
    }

    /**
     * @param array $admins
     *
     * @return array
     */
    public function addAdmins(array $admins)
    {
        return \array_map([$this, 'addAdmin'], $admins);
    }

    /**
     * @param array $admins
     */
    public function removeAdmins(array $admins)
    {
        $this->admins()->detach($admins);
    }

    /**
     * @param \App\Models\User|int $admin
     *
     * @return array|int
     */
    public function toggleAdmin($admin)
    {
        if ($this->hasAdmin($admin)) {
            return $this->removeAdmin($admin);
        }

        return $this->addAdmin($admin);
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return bool
     */
    public function isRelationCreatedBy($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->admins()->wherePivot('creator_id', $user)->exists();
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return bool
     */
    public function isManagedBy($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->admins()->whereId($user)->exists();
    }

    /**
     * 如果传入的是 admins 数组列表而非 id 列表，则提取 ID.
     *
     * @param array $admins
     *
     * @return array
     */
    public static function resolveAdminIds(array $admins): array
    {
        if (is_array($first = \reset($admins)) && \array_key_exists('id', $first)) {
            $admins = \array_column($admins, 'id');
        }

        \in_array(\Auth::id(), $admins) || \array_push($admins, \Auth::id() ?? User::SYSTEM_USER_ID);

        return $admins;
    }
}
