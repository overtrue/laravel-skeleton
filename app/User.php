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

    public function isAdmin()
    {
        return false;
    }
}
