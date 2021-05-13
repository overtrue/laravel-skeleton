<?php

namespace App\Traits;

use App\Models\Tag;

/**
 * @property \App\Models\Tag[] $tags
 * @method static saved(\Closure $param)
 * @method morphToMany(string $class, string $string)
 */
trait HasTags
{
    public static function bootHasTags()
    {
        static::saved(
            function ($model) {
                /* @var  $model \Illuminate\Database\Eloquent\Model|\App\Traits\HasTags */
                if (\request()->has('tags')) {
                    $model->tags()->sync(self::resolveTagIds(\request()->get('tags', $model->tags()->pluck('tags.id')->toArray())));
                }
            }
        );
    }

    public static function resolveTagIds(array $tags): array
    {
        if (is_array($first = \reset($tags)) && \array_key_exists('id', $first)) {
            $tags = \array_column($tags, 'id');
        }

        return $tags;
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTrashed();
    }

    public function addTags(array $tags)
    {
        $tagsIds = $this->tags->pluck('id')->merge(self::resolveTagIds($tags));

        $this->tags()->sync($tagsIds ?? []);
    }

    public function deleteTags(array $tags)
    {
        $tagsIds = $this->tags->pluck('id')->diff(self::resolveTagIds($tags));

        $this->tags()->sync($tagsIds ?? []);
    }
}
