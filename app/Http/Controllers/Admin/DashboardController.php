<?php
namespace App\Http\Controllers\Admin;

use App\Services\StatisticsService;

class DashboardController extends AdminController {

    protected $stats;

    public function __construct(StatisticsService $stats)
    {
        $this->stats = $stats;
    }

    public function index()
    {
        $template['pageTitle'] = 'Dashboard';
        $template['matchStats'] = $this->stats->getMatchesOutcomeStatistics();
        $template['byMonth'] = $this->stats->getMatchesOutcomeByMonth();
        
        return view('admin.dashboard.index', $template);
    }

} 