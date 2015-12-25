<?php namespace Comet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Team
 *
 * @property integer $id 
 * @property string $name 
 * @property string $description 
 * @property string $image 
 * @property integer $game_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comet\User[] $roster 
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Team whereDeletedAt($value)
 */
class Team extends Model {

    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'image', 'game_id'];

    protected $dates = ['deleted_at'];

    public function roster()
    {
        return $this->belongsToMany(User::class, 'team_roster')
                ->whereNull('team_roster.deleted_at')
                ->withPivot('position', 'captain', 'status', 'id');
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }

}
