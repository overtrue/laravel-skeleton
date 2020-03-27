<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\Traits\Filterable;
use App\Traits\HasCacheProperty;
use App\Traits\HasExtendsProperty;
use App\Traits\HasSettingsProperty;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use HasSettingsProperty;
    use HasCacheProperty;
    use HasExtendsProperty;
    use Filterable;

    // 性别
    const GENDER_NONE = 'none';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    //系统用户Id
    const SYSTEM_USER_ID = 1;

    /**
     * 可以对外输出字段.
     */
    const SAFE_FIELDS = [
        'id', 'name', 'real_name', 'username', 'avatar', 'is_admin',
    ];

    const DEFAULT_AVATAR = '/img/default-avatar.png';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVATED = 'inactivated';
    const STATUS_FROZEN = 'frozen';

    const STATUS_LABELS = [
        self::STATUS_INACTIVATED => '未激活',
        self::STATUS_ACTIVE => '正常',
        self::STATUS_FROZEN => '已冻结',
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
        'creator_id', 'name', 'real_name', 'username', 'avatar', 'email', 'phone', 'gender', 'status',
        'birthday', 'email_verified_at', 'password', 'cache', 'extends', 'settings',
        'is_admin', 'is_visible', 'last_active_at', 'frozen_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_visible',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'creator_id' => 'int',
        'phone' => 'int',
        'cache' => 'array',
        'extends' => 'array',
        'settings' => 'array',
        'is_admin' => 'bool',
        'is_visible' => 'bool',
        'birthday' => 'date',
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->username = $user->username ?? $user->email;
            $user->name = $user->name ?? $user->real_name ?? $user->username;

            if (Hash::needsRehash($user->password)) {
                $user->password = \bcrypt($user->password);
            }

            if ($user->isDirty('is_admin') && !\app()->runningInConsole()) {
                if (!optional(\auth()->user())->is_admin) {
                    \abort(403, '非法操作');
                }
            }

            if ($user->isDirty('status') || $user->isDirty('is_admin')) {
                if ($user->isDirty('status') && $user->status === self::STATUS_FROZEN) {
                    $user->frozen_at = now();
                }
            }
        });
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? self::DEFAULT_AVATAR;
    }

    /**
     * @return string
     */
    public function getDisplayStatusAttribute()
    {
        return self::STATUS_LABELS[$this->status ?? self::STATUS_ACTIVE];
    }

    public function filterSearch($query, $keyword)
    {
        $keyword = \sprintf('%%%s%%', $keyword);

        return $query->where('name', 'like', $keyword)->orWhere('username', 'like', $keyword);
    }

    /**
     * @param string $device
     *
     * @return array
     */
    public function createDeviceToken(string $device = null)
    {
        return [
            'token_type' => 'bearer',
            'token' => $this->createToken($device ?? Device::PC)->plainTextToken,
        ];
    }

    /**
     * @return array
     */
    public function attributesToArray()
    {
        if (\auth()->check() && auth()->user()->is($this)) {
            return parent::attributesToArray();
        }

        return Arr::only(parent::attributesToArray(), self::SAFE_FIELDS);
    }
}
