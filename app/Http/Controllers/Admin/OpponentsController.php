<?php namespace App\Http\Controllers\Admin;

use App\CometGridView;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SaveOpponentRequest;

class OpponentsController extends AdminController {

    protected $opponents;

    public function __construct(OpponentsRepositoryInterface $opponents)
    {
        $this->opponents = $opponents;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page       = $request->query('page');
        $sortColumn = $request->query('sort');
        $order      = $request->query('order');

        $grid = new CometGridView($this->opponents);
        $grid->setOrder($order);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn);
        $grid->setPath($request->getPathInfo());

        $data = $grid->gridPage($page, 15);

        return view('admin.opponents.index', $data);
    }

    public function create()
    {
        $data['opponent'] = null;

        return view('admin.opponents.form', $data);
    }

    public function save(SaveOpponentRequest $request)
    {
        $message = 'Opponent creation failed!';

        $opponent = $this->opponents->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        if ($opponent) {
            $message = 'New opponent created successfully!';
        }

        return redirect('admin/opponents')->with('message', $message);
    }

    public function edit($id)
    {
        $data['opponent'] = $this->opponents->get($id);

        return view('admin.opponents.form', $data);
    }

    public function update($id, SaveOpponentRequest $request)
    {
        $message = 'Opponent edit failed!';
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ];

        if ($this->opponents->update($id, $data)) {
            $message = 'Opponent succesfully edited!';
        }

        return redirect('admin/opponents')->with('message', $message);
    }

    public function delete($id)
    {
        $message = 'Opponent deleting failed!';
        if ($this->opponents->delete($id)) {
            $message = 'Opponent deleted succesfully!';
        }

        return redirect('admin/opponents')->with('message', $message);
    }

}
