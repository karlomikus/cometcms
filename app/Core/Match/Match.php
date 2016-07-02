<?php
namespace Comet\Core\Match;

use Comet\Core\Team\Team;
use Comet\Core\Game\Game;
use Comet\Core\Opponent\Opponent;
use Comet\Core\Match\MatchRounds;
use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Match
 *
 * @package Comet\Core\Match
 */
class Match extends EloquentModel
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['participants'];
    protected $dates = ['date', 'deleted_at'];

    public function opponent()
    {
        return $this->belongsTo(Opponent::class)->withTrashed();
    }

    public function team()
    {
        return $this->belongsTo(Team::class)->withTrashed();
    }

    public function rounds()
    {
        return $this->hasMany(MatchRounds::class)->withTrashed();
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
        return $this->belongsTo(Game::class);
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
        if ($this->home_score > $this->guest_score) {
            return 'win';
        } elseif ($this->home_score < $this->guest_score) {
            return 'lose';
        }

        return 'draw';
    }
}
