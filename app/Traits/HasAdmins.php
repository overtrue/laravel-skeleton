<?php

namespace App\Traits;

use App\Pivots\MorphPivotWithCreator;
use App\Models\User;

/**
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @method static saved(\Closure $param)
 * @method static created(\Closure $param)
 * @method morphToMany(string $class, string $string)
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

    public function admins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(User::class, 'adminable')
            ->using(MorphPivotWithCreator::class)
            ->withTimestamps()
            ->withTrashed()
            ->withPivot('creator_id')
            ->wherePivot('user_id', '<>', User::SYSTEM_USER_ID);
    }

    public function addAdmin(User|int $user): array
    {
        return $this->admins()->syncWithoutDetaching($user);
    }

    public function removeAdmin(User|int $user): int
    {
        return $this->admins()->detach($user);
    }

    public function hasAdmin(User|int $user): bool
    {
        return $this->isManagedBy($user);
    }

    public function addAdmins(array $admins): array
    {
        return \array_map([$this, 'addAdmin'], $admins);
    }

    public function removeAdmins(array $admins)
    {
        $this->admins()->detach($admins);
    }

    public function toggleAdmin($admin): int|array
    {
        if ($this->hasAdmin($admin)) {
            return $this->removeAdmin($admin);
        }

        return $this->addAdmin($admin);
    }

    public function isRelationCreatedBy(User|int $user): bool
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
