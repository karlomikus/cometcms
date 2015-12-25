<?php
namespace Comet\Core\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Comet\User
 *
 * @property integer $id
 * @property string $name
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property string $image
 * @property string $remember_token
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Comet\UsersProfile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\User whereUpdatedAt($value)
 * @property string $username
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'image'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    /**
     * User profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UsersProfile::class);
    }

}