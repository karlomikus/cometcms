<?php
namespace Comet\Core\User;

use Comet\Core\Role\Role;
use Comet\Core\User\Profile;
use Comet\Core\User\Models\UserBaseModel;

/**
 * User
 *
 * @package Comet\Core\User
 */
class User extends UserBaseModel
{
    /**
     * Users roles
     *
     * @return Collection
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Users profile
     *
     * @return Profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
