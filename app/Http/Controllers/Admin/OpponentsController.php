<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libraries\GridView\GridView;
use App\Http\Requests\SaveOpponentRequest;
use App\Http\Controllers\Admin\TraitTrashable as Trash;
use App\Repositories\Contracts\OpponentsRepositoryInterface;

/**
 * Opponents backend module. Uses trashable trait.
 * 
 * @category Admin controllers
 */
class OpponentsController extends AdminController {

    use Trash;

    /**
     * Local repository instance
     */
    private $opponents;

    public function __construct(OpponentsRepositoryInterface $opponents)
    {
        parent::__construct();

        $this->opponents = $opponents;
        $this->trashInit($this->opponents, 'admin/opponents/trash', 'admin.opponents.trash');
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->opponents);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Opponents';

        return view('admin.opponents.index', $data);
    }

    public function create()
    {
        $template = [
            'opponent' => null,
            'pageTitle' => 'Create new opponent'
        ];

        return view('admin.opponents.form', $template);
    }

    public function save(SaveOpponentRequest $request)
    {
        $opponent = $this->opponents->insert([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'image'       => null
        ]);

        if ($opponent) {
            if ($request->hasFile('image')) {
                $this->opponents->insertImage($opponent->id, $request->file('image'));
            }
            $this->alerts->alertSuccess('New opponent created successfully!');
        } else {
            $this->alerts->alertError('Opponent creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents');
    }

    public function edit($id)
    {
        $template = [
            'opponent' => $this->opponents->get($id),
            'pageTitle' => 'Editing an opponent'
        ];

        return view('admin.opponents.form', $template);
    }

    public function update($id, SaveOpponentRequest $request)
    {
        $data = [
            'name'        => $request->input('name'),
            'description' => $request->input('description')
        ];

        $opponent = $this->opponents->update($id, $data);

        if ($opponent) {
            if ($request->hasFile('image')) {
                $this->opponents->updateImage($id, $request->file('image'));
            }
            $this->alerts->alertSuccess('Opponent succesfully edited!');
        } else {
            $this->alerts->alertError('Failed to edit an opponent!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents');
    }

    public function delete($id)
    {
        if ($this->opponents->delete($id)) {
            $this->alerts->alertSuccess('Opponent moved to trash succesfully!');
        }
        else {
            $this->alerts->alertError('Unable to trash an opponent!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents');
    }

    public function deleteImage($id)
    {
        $fileDeleted = $this->opponents->deleteImage($id);

        $message = 'Error while deleting a file!';
        if($fileDeleted) {
            $message = 'File deleted successfully!';
        }
        return response()->json(['success' => $fileDeleted, 'message' => $message]);
    }

}
