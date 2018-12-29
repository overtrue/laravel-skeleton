<?php

namespace App\Traits;

/**
 * Trait HasExtendProperties.
 *
 * @author artisan <artisan@tencent.com>
 *
 * @property array $properties
 */
trait HasExtendProperties
{
    /**
     * @return array
     */
    public function getPropertiesAttribute()
    {
        $default = \defined('static::DEFAULT_PROPERTIES') ? \constant('static::DEFAULT_PROPERTIES') : [];

        return \array_merge($default, $this->attributes['properties'] ?? []);
    }
}
