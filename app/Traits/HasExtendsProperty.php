<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasExtendsProperty.
 *
 * @property array $extends
 */
trait HasExtendsProperty
{
    /**
     * @param array $extends
     */
    public function setExtendsAttribute($extends)
    {
        $this->attributes['extends'] = json_encode(\array_replace_recursive($this->getExtends(), $extends));
    }

    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getExtendsAttribute()
    {
        return new Fluent($this->getExtends());
    }

    /**
     * @return array
     */
    public function getExtends()
    {
        return \array_replace_recursive(\defined('static::DEFAULT_EXTENDS') ? \constant('static::DEFAULT_EXTENDS') : [], \json_decode($this->attributes['extends'] ?? '{}', true) ?? []);
    }
}
