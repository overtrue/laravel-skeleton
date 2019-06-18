<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasCacheProperty
 *
 * @author v_haodouliu <v_haodouliu@tencent.com>
 */
trait HasCacheProperty
{
    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getCacheAttribute()
    {
        $default = \defined('static::DEFAULT_CACHE') ? \constant('static::DEFAULT_CACHE') : [];

        return new Fluent(\array_merge($default, \json_decode($this->attributes['cache'] ?? '{}', true) ?? []));
    }
}
