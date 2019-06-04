<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // 性别
    const GENDER_NONE = 'none';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    //系统用户Id
    const SYSTEM_USER_ID = 1;

    const SENSITIVE_FIELDS = [
        'email',
    ];

    const DEFAULT_AVATAR = '/img/default-avatar.png';

    const FILTERABLE = [
        'name',
    ];

    // 默认缓存信息
    const DEFAULT_CACHE = [];

    // 默认设置信息
    const DEFAULT_SETTINGS = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->name = $user->name ?? $user->realname;

            if (Hash::needsRehash($user->password)) {
                $user->password = \bcrypt($user->password);
            }

            if ($user->isDirty('is_admin') && !\app()->runningInConsole()) {
                if (!optional(\auth()->user())->is_admin) {
                    \abort(403, '非法操作');
                }
            }
        });
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? self::DEFAULT_AVATAR;
    }

    public function filterSearch($query, $keyword)
    {
        $keyword = \sprintf('%%%s%%', $keyword);

        return $query->where('name', 'like', $keyword)->orWhere('username', 'like', $keyword);
    }

    public function toArray()
    {
        if (\auth()->check() && \auth()->user()->is($this)) {
            return parent::toArray();
        }

        return Arr::except(parent::toArray(), self::SENSITIVE_FIELDS);
    }
}
