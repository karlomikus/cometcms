<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Match
 *
 * @property-read \App\Opponent $opponent
 * @property-read \App\Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MatchRounds[] $rounds
 * @property-read \App\Game $game
 * @property integer $id 
 * @property integer $team_id 
 * @property integer $opponent_id 
 * @property integer $game_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereOpponentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereUpdatedAt($value)
 */
class Match extends Model {

    public function opponent()
    {
        return $this->belongsTo('App\Opponent');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function rounds()
    {
        return $this->hasMany('App\MatchRounds');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function getScoreAttribute()
    {
        // TODO: Optimize number of queries for matches scores, maybe use eloquent join...
        $result = \DB::table('round_scores')
            ->join('match_rounds', 'round_scores.round_id', '=', 'match_rounds.id')
            ->select(\DB::raw('sum(score_home) as home, sum(score_guest) as guest'))
            ->where('match_id', '=', $this->id)
            ->first();

        return $result;
    }

    public function getOutcomeAttribute()
    {
        $score = $this->getScoreAttribute();

        if ($score->home > $score->guest)
            return 'win';
        elseif ($score->home < $score->guest)
            return 'lose';

        return 'draw';
    }

}