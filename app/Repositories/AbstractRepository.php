<?php
namespace App\Repositories;

use App\Repositories\Contracts\AbstractRepositoryInterface;

abstract class AbstractRepository implements AbstractRepositoryInterface {

    protected $model;

    /**
     * Inject the model dependecy
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get all items
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get single item
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new item
     * @param $data
     */
    public function insert($data)
    {
        $this->model->create($data);
    }

    /**
     * Update a single item
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $this->model->find($id)->update($data);
    }

    /**
     * Delete a single item
     * @param $id
     */
    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

}