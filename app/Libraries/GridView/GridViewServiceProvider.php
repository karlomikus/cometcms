<?php
namespace App\Libraries\GridView;

use Illuminate\Support\ServiceProvider;

class GridViewServiceProvider extends ServiceProvider {

    public function register()
    {
    }

    public function boot()
    {
        \Form::macro('gridHeader', function($label, $columnName, $action, array $data)
        {
            $caret = $data['order'] == 'asc' ? '<i class="fa fa-caret-up"></i>' : '<i class="fa fa-caret-down"></i>';

            $template = "<a href=\"". action($action, ['sort' => $columnName, 'order' => $data['order'] == 'asc' ? 'desc' : 'asc', 'page' => $data['page'], 'search' => $data['search']]) ."\">";
            $template .= "{$label} ";
            $template .= ($data['column'] == $columnName ? $caret : "");
            $template .= "</a>";

            return $template;
        });
    }

}