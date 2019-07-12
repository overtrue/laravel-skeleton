<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasCacheProperty.
 *
 * @author v_haodouliu <v_haodouliu@tencent.com>
 */
trait HasCacheProperty
{
    /**
     * @param array $cache
     */
    public function setCacheAttribute($cache)
    {
        $this->attributes['cache'] = json_encode(\array_replace_recursive($this->getCache(), $cache));
    }

    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getCacheAttribute()
    {
        return new Fluent($this->getCache());
    }

    /**
     * @return array
     */
    public function getCache()
    {
        return \array_replace_recursive(\defined('static::DEFAULT_CACHE') ? \constant('static::DEFAULT_CACHE') : [], \json_decode($this->attributes['cache'] ?? '{}', true) ?? []);
    }
}
