<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * @property \Illuminate\Support\Fluent $cache
 */
trait HasCacheProperty
{
    public function setCacheAttribute(array $cache)
    {
        $this->attributes['cache'] = json_encode($cache);
    }

    public function getCacheAttribute(): Fluent
    {
        return new Fluent($this->getCache());
    }

    public function getCache(): array
    {
        return \array_replace_recursive(\defined('static::DEFAULT_CACHE') ? \constant('static::DEFAULT_CACHE') : [], \json_decode($this->attributes['cache'] ?? '{}', true) ?? []);
    }
}
