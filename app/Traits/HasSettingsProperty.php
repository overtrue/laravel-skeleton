<?php

namespace App\Traits;

use Illuminate\Support\Fluent;

/**
 * Trait HasSettingsProperty.
 *
 * @author artisan <artisan@tencent.com>
 *
 * @property \Illuminate\Support\Fluent $settings
 */
trait HasSettingsProperty
{
    /**
     * @return \Illuminate\Support\Fluent
     */
    public function getSettingsAttribute()
    {
        $default = \defined('static::DEFAULT_SETTINGS') ? \constant('static::DEFAULT_SETTINGS') : [];

        return new Fluent(\array_merge($default, \json_decode($this->attributes['settings'] ?? '{}', true) ?? []));
    }
}
