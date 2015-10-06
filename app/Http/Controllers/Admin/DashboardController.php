<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Services\StatisticsService;

class DashboardController extends AdminController {

    protected $stats;
    private $matches;

    public function __construct(StatisticsService $stats, MatchesRepositoryInterface $matches)
    {
        parent::__construct();

        $this->stats = $stats;
        $this->matches = $matches;
    }

    public function index(TeamsRepositoryInterface $teams)
    {
        $template['pageTitle'] = 'Dashboard';
        $template['matchStats'] = $this->stats->getMatchesOutcomeStatistics();
        $template['byMonth'] = $this->stats->getMatchesOutcomeByMonth();
        $template['latestMatch'] = $this->stats->getLatestMatch();
        $template['teams'] = $teams->all()->take(3);

        return view('admin.dashboard.index', $template);
    }

} 