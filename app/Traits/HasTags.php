<?php

namespace App\Traits;

use App\Tag;

/**
 * @property \App\Tag[] $tags
 */
trait HasTags
{
    public static function bootHasTags()
    {
        static::saved(function ($model) {
            /* @var  $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasTags */
            if (\request()->has('tags')) {
                $model->tags()->sync(self::resolveTagIds(\request()->get('tags', $model->tags()->pluck('tags.id')->toArray())));
            }
        });
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    public static function resolveTagIds(array $tags): array
    {
        if (is_array($first = \reset($tags)) && \array_key_exists('id', $first)) {
            $tags = \array_column($tags, 'id');
        }

        return $tags;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTrashed();
    }

    /**
     * @param array $tags
     */
    public function addTags(array $tags)
    {
        $tagsIds = $this->tags->pluck('id')->merge(self::resolveTagIds($tags));

        $this->tags()->sync($tagsIds ?? []);
    }

    /**
     * @param array $tags
     */
    public function deleteTags(array $tags)
    {
        $tagsIds = $this->tags->pluck('id')->diff(self::resolveTagIds($tags));

        $this->tags()->sync($tagsIds ?? []);
    }
}
