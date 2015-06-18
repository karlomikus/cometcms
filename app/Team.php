<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Team
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereUpdatedAt($value)
 */
class Team extends Model {

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'image', 'game_id'];

    public function roster()
    {
        return $this->belongsToMany('App\User', 'team_roster')->withPivot('position', 'captain', 'status');;
    }

}
