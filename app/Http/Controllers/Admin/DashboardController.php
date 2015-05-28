<?php
namespace App\Http\Controllers\Admin;

class DashboardController extends AdminController {

    public function index()
    {
        $data['pageTitle'] = 'Dashboard';
        
        return view('admin.dashboard.index', $data);
    }

} 