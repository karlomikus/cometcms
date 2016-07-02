<?php
namespace Comet\Core\User\Models;

use Comet\Core\Common\EloquentModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * User Base Model
 *
 * @package Comet\Core\User
 */
class UserBaseModel extends EloquentModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['username', 'email', 'password', 'image'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];
}
