<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

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
     * @return \Illuminate\Support\Fluent
     */
    public function getPropertiesAttribute()
    {
        $default = \defined('static::DEFAULT_PROPERTIES') ? \constant('static::DEFAULT_PROPERTIES') : [];

        return new Fluent(\array_merge($default, \json_decode($this->attributes['properties'] ?? '{}', true) ?? []));
    }
}
