<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * @property \Illuminate\Support\Fluent $settings
 */
trait HasSettingsProperty
{
    public function setSettingsAttribute(array $settings)
    {
        $this->attributes['settings'] = json_encode($settings);
    }

    public function getSettingsAttribute(): Fluent
    {
        return new Fluent($this->getSettings());
    }

    public function getSettings(): array
    {
        return \array_replace_recursive(\defined('static::DEFAULT_SETTINGS') ? \constant('static::DEFAULT_SETTINGS') : [], \json_decode($this->attributes['settings'] ?? '{}', true) ?? []);
    }
}
