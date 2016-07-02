<?php
namespace Comet\Core\Post;

use Comet\Core\User\User;
use Comet\Core\Post\PostCategory;
use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Post
 *
 * @package Comet\Core\Post
 */
class Post extends EloquentModel
{
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
