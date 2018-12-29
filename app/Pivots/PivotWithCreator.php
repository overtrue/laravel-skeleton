<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class PivotWithCreator.
 *
 * @author artisan <artisan@tencent.com>
 */
class PivotWithCreator extends Pivot
{
    protected $connection = 'mysql';

    public function fill(array $attributes)
    {
        return parent::fill(\array_merge($attributes, ['creator_id' => $attributes['creator_id'] ?? \auth()->id()]));
    }
}
