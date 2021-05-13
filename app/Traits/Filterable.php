<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @method static filter(array $input = [])
 */
trait Filterable
{
    public function scopeFilter(Builder $query, ?array $input = null)
    {
        $input = $input && \is_array($input) ? $input : \request()->query();

        foreach ($input as $key => $value) {
            if ($value == ($this->ignoreFilterValue ?? 'all')) {
                continue;
            }

            $method = 'filter' . Str::studly($key);
            if (\method_exists($this, $method)) {
                \call_user_func([$this, $method], $query, $value, $key);
            } elseif ($this->isFilterable($key)) {
                if (\is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }

    public function isFilterable(string $key): bool
    {
        return \property_exists($this, 'filterable') && \in_array($key, $this->filterable);
    }

    /**
     * @example
     * <pre>
     *  order_by=id:desc
     *  order_by=age:desc,created_at:asc...
     * </pre>
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $value
     */
    public function filterOrderBy(Builder $query, $value)
    {
        $segments = \explode(',', $value);

        foreach ($segments as $segment) {
            list($key, $direction) = array_pad(\explode(':', $segment), 2, 'desc');

            $query->orderBy($key, $direction);
        }
    }
}
