<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Match
 *
 * @property integer $id 
 * @property integer $team_id 
 * @property integer $opponent_id 
 * @property integer $game_id 
 * @property string $matchlink 
 * @property string $opponent_participants 
 * @property string $standins 
 * @property \Carbon\Carbon $date 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \App\Opponent $opponent 
 * @property-read \App\Team $team 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MatchRounds[] $rounds 
 * @property-read mixed $participants 
 * @property-read \App\Game $game 
 * @property-read mixed $outcome 
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereOpponentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereMatchlink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereOpponentParticipants($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereStandins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Match whereDeletedAt($value)
 */
class Match extends Model {

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['participants'];
    protected $dates = ['date', 'deleted_at'];

    public function opponent()
    {
        return $this->belongsTo('App\Opponent')->withTrashed();
    }

    public function team()
    {
        return $this->belongsTo('App\Team')->withTrashed();
    }

    public function rounds()
    {
        return $this->hasMany('App\MatchRounds')->withTrashed();
    }

    public function getParticipantsAttribute()
    {
        $teamParticipants = $this->join('match_participants', 'match_participants.match_id', '=', 'matches.id')
            ->join('team_roster', 'team_roster.id', '=', 'match_participants.roster_id')
            ->join('users', 'users.id', '=', 'team_roster.user_id')
            ->where('matches.id', '=', $this->id)
            ->get(['team_roster.*', 'users.name']);

        $opponentParticipants = preg_split("/[\t]/", $this->opponent_participants);

        return ['team' => $teamParticipants, 'opponent' => $opponentParticipants];
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    // public function getScoreAttribute()
    // {
    //     // $result = $this->join('match_rounds', 'match_rounds.match_id', '=', 'matches.id')
    //     // ->join('round_scores', 'round_scores.round_id', '=', 'match_rounds.id')
    //     // ->select(\DB::raw('sum(round_scores.home) as home, sum(round_scores.guest) as guest'))
    //     // ->where('matches.id', $this->id)
    //     // ->first();
    //     //dd($result);
    //     // TODO: Optimize number of queries for matches scores, maybe use eloquent join...
    //     // $result = \DB::table('round_scores')
    //     //     ->join('match_rounds', 'round_scores.round_id', '=', 'match_rounds.id')
    //     //     ->select(\DB::raw('sum(home) as home, sum(guest) as guest'))
    //     //     ->where('match_id', '=', $this->id)
    //     //     ->first();

    //     $result = $this->join('match_rounds', 'match_rounds.match_id', '=', 'matches.id')
    //     ->join('round_scores', 'round_scores.round_id', '=', 'match_rounds.id')
    //     ->select(\DB::raw('sum(round_scores.home) as home, sum(round_scores.guest) as guest'))
    //     ->where('matches.id', $this->id)
    //     ->first();

    //     return $result;
    // }

    public function getOutcomeAttribute()
    {
        // home_score and guest_score come from separate query
        // TODO: Add check for missing scores
        if ($this->home_score > $this->guest_score)
            return 'win';
        elseif ($this->home_score < $this->guest_score)
            return 'lose';

        return 'draw';
    }

}