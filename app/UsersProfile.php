<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UsersProfile
 *
 * @property integer $id 
 * @property integer $user_id 
 * @property string $first_name 
 * @property string $last_name 
 * @property string $image 
 * @property string $bio 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\User $user 
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UsersProfile whereUpdatedAt($value)
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
        return $this->belongsTo('App\User');
    }

}
