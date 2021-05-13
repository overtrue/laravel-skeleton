<?php

namespace App\Models;

use App\Traits\BelongsToCreator;
use App\Traits\UseTableNameAsMorphClass;
use App\Traits\UsingUuidAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use BelongsToCreator;
    use UseTableNameAsMorphClass;
    use UsingUuidAsPrimaryKey;

    protected $fillable = [
        'creator_id',
        'name',
        'color',
        'icon',
    ];

    public function taggable()
    {
        return $this->morphTo();
    }
}
