<?php namespace Comet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Comet\Libraries\GridView\GridView;
use Comet\Http\Requests\SaveOpponentRequest;
use Comet\Http\Controllers\Admin\TraitTrashable as Trash;
use Comet\Core\Repositories\Contracts\OpponentsRepositoryInterface as Opponents;

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

    /**
     * @param Opponents $opponents
     */
    public function __construct(Opponents $opponents)
    {
        parent::__construct();

        $this->opponents = $opponents;
        $this->trashInit($this->opponents, 'admin/opponents/trash', 'admin.opponents.trash');
        $this->breadcrumbs->addCrumb('Opponents', 'opponents');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $grid = new GridView($this->opponents);
        $data = $grid->gridPage(15);

        $data['pageTitle'] = 'Opponents';

        return view('admin.opponents.index', $data);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $template = [
            'opponent'  => null,
            'pageTitle' => 'Create new opponent'
        ];

        return view('admin.opponents.form', $template);
    }

    /**
     * @param SaveOpponentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
        }
        else {
            $this->alerts->alertError('Opponent creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents');
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $template = [
            'opponent'  => $this->opponents->get($id),
            'pageTitle' => 'Editing an opponent'
        ];

        return view('admin.opponents.form', $template);
    }

    /**
     * @param $id
     * @param SaveOpponentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
        }
        else {
            $this->alerts->alertError('Failed to edit an opponent!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id)
    {
        $fileDeleted = $this->opponents->deleteImage($id);

        $message = 'Error while deleting a file!';
        if ($fileDeleted) {
            $message = 'File deleted successfully!';
        }

        return response()->json(['success' => $fileDeleted, 'message' => $message]);
    }

}
