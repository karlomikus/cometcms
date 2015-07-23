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
     * @param $columns
     * @return mixed
     */
    public function get($id, $with = [], $columns = ['*'])
    {
        return $this->model->withTrashed()->with($with)->find($id, $columns);
    }

    /**
     * Create new item
     * @param $data
     */
    public function insert($data)
    {
        $model = null;

        try {
            $model = $this->model->create($data);
        }
        catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $model;
    }

    /**
     * Update a single item
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $model = null;

        try {
            $model = $this->model->find($id);
            $model->update($data);
        }
        catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $model;
    }

    /**
     * Delete a single item
     * @param $id
     */
    public function delete($id)
    {
        $deleted = false;

        try {
            $deleted = $this->model->find($id)->delete();
        }
        catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $deleted;
    }

    public function getTrash()
    {
        return $this->model->onlyTrashed()->get();
    }

}