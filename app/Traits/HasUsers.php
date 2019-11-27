<?php

namespace App\Traits;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasUsers.
 *
 * @property \Illuminate\Database\Eloquent\Collection $users
 */
trait HasUsers
{
    public static function bootHasUsers()
    {
        static::saved(function ($model) {
            /* @var  $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasUsers */
            if (!\app()->runningInConsole() || \app()->runningUnitTests()) {
                if (\request()->has('users') && \request()->routeIs(\sprintf('*%s.*', $model->getTable()))) {
                    $users = self::resolveUserIds(\request()->get('users', []));

                    if ($model->getUserRelationMergeStrategy() === 'as_default' && empty($users)) {
                        \array_push($users, \Auth::id() ?? User::SYSTEM_USER_ID);
                    }

                    if ($model->getUserRelationMergeStrategy() === 'force_append') {
                        \in_array(\Auth::id(), $users) || \array_push($users, \Auth::id() ?? User::SYSTEM_USER_ID);
                    }
                    $model->users()->sync($users);
                }
            }
        });

        static::created(function ($model) {
            /** @var $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasUsers */
            // 此方法与上面没有重复，请不要删除
            if (\Auth::check() && ($model->getUserRelationMergeStrategy() === 'force_append' || empty(\request()->get('users', [])))) {
                $model->addUser(\Auth::id());
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->getUsersPivotTable())->withTimestamps();
    }

    /**
     * @param \App\User|int $user
     *
     * @return mixed
     */
    public function hasUser($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->users()->whereId($user)->exists();
    }

    /**
     * @param \App\User|int $user
     *
     * @return array
     */
    public function addUser($user)
    {
        return $this->users()->syncWithoutDetaching($user);
    }

    /**
     * @param \App\User|int $user
     *
     * @return int
     */
    public function removeUser($user)
    {
        return $this->users()->detach($user);
    }

    /**
     * @param array $users
     *
     * @return array
     */
    public function addUsers(array $users)
    {
        return \array_map([$this, 'addUser'], $users);
    }

    /**
     * @param array $users
     */
    public function removeUsers(array $users)
    {
        $this->users()->detach(\collect($users)->pluck('id'));
    }

    /**
     * @param \App\User|int $user
     *
     * @return array|int
     */
    public function toggleUser($user)
    {
        if ($this->hasUser($user)) {
            return $this->removeUser($user);
        }

        return $this->addUser($user);
    }

    /**
     * @return string
     */
    protected function getUsersPivotTable()
    {
        return \property_exists($this, 'usersPivotTable') ? $this->usersPivotTable : \sprintf('%s_user', Str::singular($this->getTable()));
    }

    /**
     * @return string
     */
    protected function getUserRelationMergeStrategy()
    {
        if (property_exists($this, 'userRelationMergeStrategy')) {
            return $this->userRelationMergeStrategy;
        }

        return 'as_default';
    }

    /**
     * 如果传入的是 users 数组列表而非 id 列表，则提取 ID.
     *
     * @param array $users
     *
     * @return array
     */
    public static function resolveUserIds(array $users): array
    {
        if (is_array($first = \reset($users)) && \array_key_exists('id', $first)) {
            $users = \array_column($users, 'id');
        }

        return $users;
    }
}
