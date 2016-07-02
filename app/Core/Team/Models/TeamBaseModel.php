<?php
namespace Comet\Core\Team\Models;

use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Team Base Model
 *
 * @package Comet\Core\Team
 */
class TeamBaseModel extends EloquentModel
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'image', 'game_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['roster'];
}
