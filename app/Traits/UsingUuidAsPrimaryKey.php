<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UsingUuidAsPrimaryKey
{
    public static function bootUsingUuidAsPrimaryKey(): void
    {
        static::creating(function (self $model): void {
            /* @var \Illuminate\Database\Eloquent\Model|\App\Traits\UsingUuidAsPrimaryKey $model */
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
