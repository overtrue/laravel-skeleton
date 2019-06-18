<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasExtendsProperty.
 *
 * @property \Illuminate\Support\Fluent $extends
 */
trait HasExtendsProperty
{
    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getPropertiesAttribute()
    {
        $default = \defined('static::DEFAULT_EXTENDS') ? \constant('static::DEFAULT_EXTENDS') : [];

        return new Fluent(\array_merge($default, \json_decode($this->attributes['extends'] ?? '{}', true) ?? []));
    }
}
