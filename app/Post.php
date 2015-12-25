<?php

namespace Comet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsTo('Comet\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('Comet\PostCategory', 'post_category_id', 'id');
    }
}
