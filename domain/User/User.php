<?php

namespace Domain\User;

use function bcrypt;
use Domain\User\Filters\UserFilter;
use Domain\User\Notifications\ResetPassword;
use Domain\User\Notifications\VerifyEmail;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use function is_null;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\HasApiTokens;
use function now;

/**
 * @property string         $nickname
 * @property string         $username
 * @property string         $avatar
 * @property string         $email
 * @property string         $phone
 * @property string         $gender
 * @property \Carbon\Carbon $birthday
 * @property string         $password
 * @property object         $settings
 * @property bool           $is_admin
 * @property \Carbon\Carbon $email_verified_at
 * @property \Carbon\Carbon $first_active_at
 * @property \Carbon\Carbon $last_active_at
 * @property \Carbon\Carbon $frozen_at
 * @property string         id
 *
 * @method static where(string $string, mixed $username)
 * @method static create(array $all)
 * @method static UserFactory factory($count = null, $state = [])
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use HasFactory;
    use Filterable;

    public const SAFE_FIELDS = [
        'id',
        'nickname',
        'username',
        'avatar',
    ];

    public const DEFAULT_AVATAR = '/img/default-avatar.png';

    /**
     * @var array
     */
    protected $fillable = [
        'nickname',
        'username',
        'avatar',
        'email',
        'phone',
        'gender',
        'birthday',
        'email_verified_at',
        'password',
        'first_active_at',
        'last_active_at',
        'banned_reason',
        'banned_at',
        'settings',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
        'is_admin' => 'bool',
        'birthday' => 'date',
        'email_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'first_active_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(
            function (User $user) {
                $user->username = $user->username ?? $user->email;
                $user->nickname ??= $user->username;
                $user->first_active_at = ! is_null($user->getOriginal('first_active_at')) ? $user->first_active_at : null;

                if (Hash::needsRehash($user->password)) {
                    $user->password = bcrypt($user->password);
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

    public function isAdmin(): bool
    {
        return !!$this->is_admin;
    }

    #[ArrayShape(['type' => 'string', 'token' => 'string'])]
    public function createDeviceToken(
        ?string $device = 'web'
    ): array {
        return [
            'type' => 'bearer',
            'token' => $this->createToken($device ?: 'web')->plainTextToken,
        ];
    }

    public function refreshLastActiveAt(): static
    {
        $this->updateQuietly(
            [
                'last_active_at' => now(),
            ]
        );

        return $this;
    }

    public function refreshFirstActiveAt(): static
    {
        $this->first_active_at || $this->updateQuietly(
            [
                'first_active_at' => now(),
            ]
        );

        return $this;
    }

    public function getModelFilterClass(): string
    {
        return UserFilter::class;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
