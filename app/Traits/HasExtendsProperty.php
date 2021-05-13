<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * @property \Illuminate\Support\Fluent $extends
 */
trait HasExtendsProperty
{
    public function setExtendsAttribute(array $extends)
    {
        $this->attributes['extends'] = json_encode($extends);
    }

    public function getExtendsAttribute(): Fluent
    {
        return new Fluent($this->getExtends());
    }

    public function getExtends(): array
    {
        return \array_replace_recursive(\defined('static::DEFAULT_EXTENDS') ? \constant('static::DEFAULT_EXTENDS') : [], \json_decode($this->attributes['extends'] ?? '{}', true) ?? []);
    }
}
