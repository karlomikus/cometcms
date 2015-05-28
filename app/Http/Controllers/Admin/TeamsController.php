<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Http\Request;

class TeamsController extends AdminController {

    protected $teams;

    public function __construct(TeamsRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page       = $request->query('page');
        $sortColumn = $request->query('sort');
        $order      = $request->query('order');

        $grid = new GridView($this->teams);
        $grid->setOrder($order, 'asc');
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Teams';

        return view('admin.teams.index', $data);
    }

    public function create()
    {
        $data['opponent'] = null;
        $data['pageTitle'] = 'Create new opponent';

        return view('admin.opponents.form', $data);
    }

    public function save(SaveOpponentRequest $request)
    {
        $opponent = $this->opponents->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        if ($opponent)
            $this->alertSuccess('New opponent created successfully!', 'success');
        else
            $this->alertError('Opponent creation failed!');

        return redirect('admin/opponents')->with('alerts', $this->getAlerts());
    }

    public function edit($id)
    {
        $data['opponent'] = $this->opponents->get($id);
        $data['pageTitle'] = 'Editing an opponent';

        return view('admin.opponents.form', $data);
    }

    public function update($id, SaveOpponentRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ];

        if ($this->opponents->update($id, $data)) {
            $this->alertSuccess('Opponent succesfully edited!');
        }
        else {
            $this->alertError('Failed to edit an opponent!');
        }

        return redirect('admin/opponents')->with('message', $this->getAlerts());
    }

    public function delete($id)
    {
        try {
            $this->opponents->delete($id);
            $this->alertSuccess('Opponent deleted succesfully!');
        }
        catch (Exception $e) {
            $this->alertError('Unable to delete an opponent due to an exception!');
        }

        return redirect('admin/opponents')->with('alerts', $this->getAlerts());
    }

}
