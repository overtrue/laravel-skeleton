<?php

namespace App\Http\Resources;

use App\User;

/**
 * Class UserResource.
 *
 * @author artisan <artisan@tencent.com>
 */
class UserResource extends Resource
{
    public function toArray($request)
    {
        if ($request->user()->is($this->resource)) {
            return parent::toArray($request);
        }

        return \array_except(parent::toArray($request), User::SENSITIVE_FIELDS);
    }
}
