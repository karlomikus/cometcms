<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;

class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface, GridViewInterface {

    public function __construct(Team $team)
    {
        parent::__construct($team);
    }

    /**
     * Get members of a specific team
     *
     * @param $teamID
     * @return mixed
     */
    public function getTeamRoster($teamID)
    {
        return $this->get($teamID)->roster;
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'name'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }
}