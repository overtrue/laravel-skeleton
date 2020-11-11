<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * @property \Illuminate\Support\Fluent $settings
 */
trait HasSettingsProperty
{
    /**
     * @param array $settings
     */
    public function setSettingsAttribute($settings)
    {
        $this->attributes['settings'] = json_encode($settings);
    }

    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getSettingsAttribute()
    {
        return new Fluent($this->getSettings());
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return \array_replace_recursive(\defined('static::DEFAULT_SETTINGS') ? \constant('static::DEFAULT_SETTINGS') : [], \json_decode($this->attributes['settings'] ?? '{}', true) ?? []);
    }
}
