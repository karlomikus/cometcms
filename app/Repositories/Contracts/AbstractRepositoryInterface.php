<?php
namespace App\Repositories\Contracts;

interface AbstractRepositoryInterface {

    public function all();
    public function get($id);
    public function insert($data);
    public function update($id, $data);
    public function delete($id);

}