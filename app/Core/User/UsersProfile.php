<?php
namespace Comet\Core\User;

use Comet\Core\User\User;
use Comet\Core\Common\EloquentModel;

/**
 * User Profile
 *
 * @package Comet\Core\User
 */
class UsersProfile extends EloquentModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'image', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
