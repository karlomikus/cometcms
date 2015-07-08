<?php
namespace App\Services;

class AlertsService {

    // VALIDATION ERRORS, SYSTEM MESSAGES, EXCEPTIONS
    private $alerts;
    private $exceptionMessage;

    public function __construct()
    {
        $this->alerts = [];
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
            'message' => $message,
            'exception' => \Session::has('exception') ? \Session::get('exception') : null
        ];

        return $this;
    }

    public function getAlerts()
    {
        \Session::flash('alerts', $this->alerts);
        return $this->alerts;
    }
}