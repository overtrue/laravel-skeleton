<?php

namespace App\Traits;

/**
 * Trait QuietlyUpdate.
 */
trait QuietlyUpdate
{
    /**
     * @param array $update
     * @param array $options
     *
     * @return mixed
     */
    public function updateQuietly(array $update, array $options = [])
    {
        return static::withoutEvents(function () use ($update, $options) {
            return $this->update($options, $options);
        });
    }
}
