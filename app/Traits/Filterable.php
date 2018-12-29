<?php

namespace App\Traits;

/**
 * Trait Filterable.
 *
 * @author artisan <artisan@tencent.com>
 */
trait Filterable
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request|null         $input
     */
    public function scopeFilter($query, $input = null)
    {
        $input = $input && \is_array($input) ? $input : \request()->query();

        foreach ($input as $key => $value) {
            $method = 'filter'.\studly_case($key);

            if (\method_exists($this, $method)) {
                \call_user_func([$this, $method], $value, $query, $key);
            } elseif ($this->isFilterable($key)) {
                if (\is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function isFilterable(string $key)
    {
        return \defined('static::FILTERABLE') && \in_array($key, \constant('static::FILTERABLE'));
    }

    /**
     * @example
     * <pre>
     *  order_by=id:desc
     *  order_by=age:desc,created_at:asc...
     * </pre>
     *
     * @param string                                $value
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function filterOrderBy($value, $query)
    {
        $segments = \explode(',', $value);

        foreach ($segments as $segment) {
            list($key, $direction) = array_pad(\explode(':', $segment), 2, 'desc');

            $query->orderBy($key, $direction);
        }
    }
}
