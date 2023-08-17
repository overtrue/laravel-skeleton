<?php

namespace Domain\Tag;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Traits\UseTableNameAsMorphClass;
use Kra8\Snowflake\HasShortflakePrimary;

/**
 * @property string $creator_id
 * @property string $name
 * @property string $color
 * @property string $icon
 * @property Model  $taggable
 */
class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasShortflakePrimary;
    use UseTableNameAsMorphClass;

    protected $fillable = [
        'creator_id',
        'name',
        'color',
        'icon',
    ];

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}
