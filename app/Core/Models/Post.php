<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Core\Models\Post
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $slug
 * @property integer $post_category_id
 * @property \Carbon\Carbon $publish_date_start
 * @property \Carbon\Carbon $publish_date_end
 * @property string $status
 * @property boolean $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Comet\Core\Models\User $author
 * @property-read \Comet\Core\Models\PostCategory $category
 */
class Post extends Model {

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'content',
        'slug',
        'post_category_id',
        'status',
        'comments',
        'publish_date_start',
        'publish_date_end'
    ];

    protected $dates = ['deleted_at', 'publish_date_start', 'publish_date_end'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    }
}
