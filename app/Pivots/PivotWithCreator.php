<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PivotWithCreator extends Pivot
{
    public function fill(array $attributes)
    {
        return parent::fill(\array_merge($attributes, ['creator_id' => $attributes['creator_id'] ?? \auth()->id()]));
    }
}
