<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasExtendProperties.
 *
 * @property array $properties
 */
trait HasExtendProperties
{
    /**
     * @param array $properties
     */
    public function setPropertiesAttribute($properties)
    {
        $this->attributes['properties'] = json_encode(\array_replace_recursive($this->getProperties(), $properties));
    }

    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getPropertiesAttribute()
    {
        return new Fluent($this->getProperties());
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return \array_replace_recursive(\defined('static::DEFAULT_PROPERTIES') ? \constant('static::DEFAULT_PROPERTIES') : [], \json_decode($this->attributes['properties'] ?? '{}', true) ?? []);
    }
}
