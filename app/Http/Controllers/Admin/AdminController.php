<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;

class AdminController extends Controller {

    private $alerts = [];

    public function __construct()
    {
        Session::flash('alerts', $this->getAlerts());
    }

    public function alertError($message)
    {
        return $this->alert($message, 'danger');
    }

    public function alertSuccess($message)
    {
        return $this->alert($message, 'success');
    }

    public function alertInfo($message)
    {
        return $this->alert($message, 'info');
    }

    public function alert($message, $alertType = 'info')
    {
        $this->alerts[] = [
            'type' => $alertType,
            'message' => $message
        ];

        return $this;
    }

    public function getAlerts()
    {
        return $this->alerts;
    }

} 