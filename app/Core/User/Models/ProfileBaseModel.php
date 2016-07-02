<?php
namespace Comet\Core\User\Models;

use Comet\Core\Common\EloquentModel;

/**
 * User Profile
 *
 * @package Comet\Core\User
 */
class ProfileBaseModel extends EloquentModel
{
    protected $table = 'users_profiles';

    protected $fillable = ['first_name', 'last_name', 'image', 'bio'];
}
