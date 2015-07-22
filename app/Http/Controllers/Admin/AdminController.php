<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;
use App\Services\AlertsService;

class AdminController extends Controller {

    protected $alerts;
    protected $currentUser;
    protected $trashLink;

    public function __construct()
    {
        $this->alerts = new AlertsService();
        $this->currentUser = \Auth::user();

        view()->share('trashLink', $this->trashLink);
    }

    public function trash()
    {
        $template['pageTitle'] = 'Trash';
        
        return view('admin.trash.index', $template);
    }

    public function setTrashLink($link)
    {
        $this->trashLink = $link;
    }

} 