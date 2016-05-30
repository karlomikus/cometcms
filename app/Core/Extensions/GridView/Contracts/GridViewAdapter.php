<?php
namespace Comet\Core\Extensions\GridView\Contracts;

interface GridViewAdapter
{
    public function order($col, $direction);
    public function filter($cols, $val);
    public function chunk($page, $limit);
    public function total();
}
