<?php

namespace Domain\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Traits\UseTableNameAsMorphClass;
use Kra8\Snowflake\HasShortflakePrimary;

/**
 * @property string         $user_id
 * @property string         $agent
 * @property \Carbon\Carbon $last_used_at
 */
class UserAgent extends Model
{
    use SoftDeletes;
    use UseTableNameAsMorphClass;
    use HasShortflakePrimary;

    protected $fillable = ['user_id', 'agent', 'last_used_at'];

    protected $casts = [
        'user_id' => 'string',
    ];

    protected $dates = [
        'last_used_at',
    ];

    protected static function booted()
    {
        self::saving(
            function (UserAgent $userAgent) {
                $userAgent->last_used_at = now();
            }
        );
    }

    public function refreshLastUsedAt(): static
    {
        $this->updateQuietly(['last_used_at' => now()]);

        return $this;
    }
}
