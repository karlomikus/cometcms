<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Comet\UsersProfile
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $image
 * @property string $bio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Comet\User $user
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\UsersProfile whereUpdatedAt($value)
 */
class UsersProfile extends Model {

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
