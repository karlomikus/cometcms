<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;

	protected $fillable = ['user_id', 'title', 'summary', 'content', 'slug', 'category', 'status'];

	protected $dates = ['deleted_at'];

	public function author()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
