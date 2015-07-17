<?php
namespace App\Services;

use App\Repositories\Contracts\MatchesRepositoryInterface;
use Carbon\Carbon;

class StatisticsService {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }

    public function getMatchesOutcomeStatistics()
    {
        $scores = $this->matches->getMatchesScores();
        $won = $draw = $lost = 0;

        foreach ($scores as $score) {
            if ($score->home > $score->guest)
                $won++;
            elseif ($score->home < $score->guest)
                $lost++;
            else
                $draw++;
        }

        $result = [
            'won' => $won,
            'draw' => $draw,
            'lost' => $lost,
            'total' => $scores->count()
        ];

        return $result;
    }

    public function getMatchesOutcomeByMonth()
    {
        $scores = $this->matches->getMatchesScores();
        $won = $draw = $lost = 0;

        $group = [];
        foreach ($scores as $score) {
            if ($score->home > $score->guest)
                $group[Carbon::parse($score->date)->format('m')]['won'] = $won++;
            elseif ($score->home < $score->guest)
                $group[Carbon::parse($score->date)->format('m')]['lost'] = $lost++;
            else
                $group[Carbon::parse($score->date)->format('m')]['draw'] = $draw++;
        }

        return $group;
    }

} 