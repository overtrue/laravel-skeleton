<?php

namespace App\Pivots;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * Class MorphPivotWithCreator.
 */
class MorphPivotWithCreator extends MorphPivot
{
    public function fill(array $attributes)
    {
        return parent::fill(\array_merge($attributes, ['creator_id' => $attributes['creator_id'] ?? \auth()->id() ?? User::SYSTEM_USER_ID]));
    }
}
