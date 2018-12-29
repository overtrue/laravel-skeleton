<?php

namespace App\Pivots;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * Class MorphPivotWithCreator.
 *
 * @author artisan <artisan@tencent.com>
 */
class MorphPivotWithCreator extends MorphPivot
{
    protected $connection = 'mysql';

    public function fill(array $attributes)
    {
        return parent::fill(\array_merge($attributes, ['creator_id' => $attributes['creator_id'] ?? \auth()->id() ?? User::SYSTEM_USER_ID]));
    }
}
