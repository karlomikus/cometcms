<?php

namespace Comet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model {

	use SoftDeletes;

	protected $fillable = [
		'name'
	];

	protected $dates = ['deleted_at'];
}
