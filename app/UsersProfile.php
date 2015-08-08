<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
