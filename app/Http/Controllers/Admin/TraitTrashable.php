<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;

trait TraitTrashable {

    protected $view;
    protected $data;

    public function trash()
    {
        $template['pageTitle'] = 'Trash';
        $template['data'] = $this->data->getTrash();
        
        return view($this->view, $template);
    }

    public function setTrashView($view)
    {
        $this->view = $view;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

}