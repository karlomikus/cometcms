<?php
namespace Comet\Core\Contracts;

interface RepositoryInterface
{
    public function all();
    public function get($id, $with, $columns);
    public function insert($data);
    public function update($id, $data);
    public function delete($id);
}