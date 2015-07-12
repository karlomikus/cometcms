<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\RolesRepositoryInterface;
use Illuminate\Http\Request;

class RolesController extends AdminController {

    protected $roles;

    public function __construct(RolesRepositoryInterface $roles)
    {
        $this->roles = $roles;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->roles);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'display_name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $template = $grid->gridPage($page, 15);

        $template['pageTitle'] = 'User roles';

        return view('admin.roles.index', $template);
    }

    public function create()
    {
        $template = [
            'pageTitle' => 'Create new role',
            'perms' => $this->roles->getAllPermissions(),
            'model' => null
        ];

        return view('admin.roles.form', $template);
    }

    // public function save(SaveGameRequest $request, MapsRepositoryInterface $maps)
    // {
    //     $game = $this->games->insert([
    //         'name'  => $request->input('name'),
    //         'code'  => $request->input('code'),
    //         'image' => null
    //     ]);

    //     if ($game) {
    //         if ($request->hasFile('image')) {
    //             $this->games->insertImage($game->id, $request->file('image'));
    //         }
    //         // Insert maps
    //         if ($request->has('mapname')) {
    //             $mapNames = $request->input('mapname');
    //             $totalMaps = count($mapNames);
    //             for ($i = 0; $i < $totalMaps; $i ++) {
    //                 if (!empty($mapNames[$i]))
    //                     $maps->insertMap($mapNames[$i], $game->id, $request->file('mapimage')[$i]);
    //             }
    //         }

    //         $this->alertSuccess('New game created successfully!');
    //     } else {
    //         $this->alertError('Game creation failed!');
    //     }

    //     return redirect('admin/games')->with('alerts', $this->getAlerts());
    // }

    // public function edit($id, MapsRepositoryInterface $maps)
    // {
    //     $data['pageTitle'] = 'Editing a game';
    //     $data['maps'] = $maps->getByGame($id)->toJson();
    //     $data['model'] = $this->games->get($id);

    //     return view('admin.games.form', $data);
    // }

    // public function update($id, SaveGameRequest $request, MapsRepositoryInterface $maps)
    // {
    //     $game = $this->games->update($id, [
    //         'name' => $request->input('name'),
    //         'code' => $request->input('code')
    //     ]);

    //     if ($game) {
    //         if ($request->hasFile('image')) {
    //             $this->games->updateImage($id, $request->file('image'));
    //         }

    //         if ($request->has('mapname')) {
    //             $maps->updateMaps($request->input('mapname'), $request->input('mapid'), $id, $request->file('mapimage'));
    //         }

    //         $this->alertSuccess('Game edited successfully!');
    //     } else {
    //         $this->alertError('Game edit failed!');
    //     }

    //     return redirect('admin/games')->with('alerts', $this->getAlerts());
    // }

}
