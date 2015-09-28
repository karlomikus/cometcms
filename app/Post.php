<?php

namespace App;

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

    protected $dates = ['deleted_at'];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\PostCategory', 'post_category_id', 'id');
    }
}
