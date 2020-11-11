<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UseUuid
{
    public static function bootUseUuid(): void
    {
        static::creating(function (self $model): void {
            /* @var \Illuminate\Database\Eloquent\Model|\App\Traits\UseUuid $model */
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
            }
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
