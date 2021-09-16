<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\Traits\Filterable;
use App\Traits\HasCacheProperty;
use App\Traits\HasExtendsProperty;
use App\Traits\HasSettingsProperty;
use App\Traits\UsingUuidAsPrimaryKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string         $creator_id
 * @property string         $name
 * @property string         $real_name
 * @property string         $username
 * @property string         $avatar
 * @property string         $email
 * @property string         $phone
 * @property string         $gender
 * @property string         $status
 * @property \Carbon\Carbon $birthday
 * @property string         $password
 * @property object         $cache
 * @property object         $extends
 * @property object         $settings
 * @property bool           $is_admin
 * @property bool           $is_visible
 * @property \Carbon\Carbon $email_verified_at
 * @property \Carbon\Carbon $first_active_at
 * @property \Carbon\Carbon $last_active_at
 * @property \Carbon\Carbon $frozen_at
 * @property string         id
 * @method static where(string $string, mixed $username)
 * @method static create(array $all)
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
    use HasFactory;
    use UsingUuidAsPrimaryKey;

    public const GENDER_UNKNOWN = 'unknown';
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const SAFE_FIELDS = [
        'id',
        'name',
        'real_name',
        'username',
        'avatar',
        'is_admin',
    ];
    public const DEFAULT_AVATAR = '/img/default-avatar.png';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVATED = 'inactivated';
    public const STATUS_FROZEN = 'frozen';
    public const STATUSES = [
        self::STATUS_INACTIVATED => '未激活',
        self::STATUS_ACTIVE => '正常',
        self::STATUS_FROZEN => '已冻结',
    ];
    // 默认缓存信息
    public const DEFAULT_CACHE = [];
    // 默认设置信息
    public const DEFAULT_SETTINGS = [];

    /**
     * @var array
     */
    protected $fillable = [
        'creator_id',
        'name',
        'real_name',
        'username',
        'avatar',
        'email',
        'phone',
        'gender',
        'status',
        'birthday',
        'email_verified_at',
        'password',
        'cache',
        'extends',
        'settings',
        'is_admin',
        'is_visible',
        'first_active_at',
        'last_active_at',
        'frozen_at',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_visible',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'creator_id' => 'int',
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
        'gender' => self::GENDER_UNKNOWN,
    ];

    protected static function booted()
    {
        static::saving(
            function (User $user) {
                $user->username = $user->username ?? $user->email;
                $user->name = $user->name ?? $user->real_name ?? $user->username;
                $user->first_active_at = !\is_null($user->getOriginal('first_active_at')) ? $user->first_active_at : null;

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
            }
        );
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }

    public function getAvatarAttribute(): string
    {
        return $this->attributes['avatar'] ?? self::DEFAULT_AVATAR;
    }

    public function getDisplayStatusAttribute(): string
    {
        return self::STATUSES[$this->status ?? self::STATUS_ACTIVE];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function isNotAdmin(): bool
    {
        return !$this->is_admin;
    }

    public function filterKeyword($query, $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }

        $keyword = \sprintf('%%%s%%', $keyword);

        return $query->where(
            function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)->orWhere('username', 'like', $keyword);
            }
        );
    }

    #[ArrayShape(['token_type' => "string", 'token' => "string"])]
    public function createDeviceToken(
        ?string $device = null
    ): array {
        return [
            'token_type' => 'bearer',
            'token' => $this->createToken($device ?? Device::PC)->plainTextToken,
        ];
    }

    public function refreshLastActiveAt(): static
    {
        $this->updateQuietly(
            [
                'last_active_at' => \now(),
                'status' => self::STATUS_ACTIVE,
            ]
        );

        return $this;
    }

    public function refreshFirstActiveAt(): static
    {
        $this->first_active_at || $this->updateQuietly(
            [
                'first_active_at' => \now(),
                'status' => self::STATUS_ACTIVE,
            ]
        );

        return $this;
    }

    public function attributesToArray(): array
    {
        if (\auth()->check() && $this->is(auth()->user())) {
            return parent::attributesToArray();
        }

        return Arr::only(parent::attributesToArray(), self::SAFE_FIELDS);
    }
}
