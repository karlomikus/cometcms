<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Team
 *
 * @property integer $id 
 * @property string $name 
 * @property string $description 
 * @property string $image 
 * @property integer $game_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $roster 
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereDeletedAt($value)
 */
class Team extends Model {

    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'image', 'game_id'];

    protected $dates = ['deleted_at'];

    public function roster()
    {
        return $this->belongsToMany('App\User', 'team_roster')
                ->whereNull('team_roster.deleted_at')
                ->withPivot('position', 'captain', 'status', 'id');
    }

}
