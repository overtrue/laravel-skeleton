<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Resource.
 *
 * @author artisan <artisan@tencent.com>
 */
class Resource extends JsonResource
{
    /**
     * @var array
     */
    protected static $defaultIncludes = [];

    /**
     * Resource constructor.
     *
     * @param $resource
     */
    public function __construct(Model $resource)
    {
        parent::__construct($resource);

        if ($resource->wasRecentlyCreated) {
            $resource->refresh();
        }

        $resource->loadMissing(static::getIncludeRelations());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection | \Illuminate\Contracts\Pagination\Paginator $resource
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        $resource->loadMissing(static::getIncludeRelations());

        return parent::collection($resource);
    }

    /**
     * @return array
     */
    public static function getIncludeRelations()
    {
        return array_merge(static::$defaultIncludes, \request()->includes());
    }
}
