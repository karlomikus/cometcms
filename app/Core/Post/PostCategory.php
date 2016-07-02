<?php
namespace Comet\Core\Post;

use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Core\Models\PostCategory
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class PostCategory extends EloquentModel
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at'];
}
