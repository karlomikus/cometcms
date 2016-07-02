<?php
namespace Comet\Core\User;

use Comet\Core\User\User;
use Comet\Core\User\Models\ProfileBaseModel;

/**
 * User Profile
 *
 * @package Comet\Core\User
 */
class Profile extends ProfileBaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
