<?php
namespace Comet\Core\Repositories;

use Comet\Core\Contracts\TrashableInterface;
use Comet\Core\Contracts\RepositoryInterface;

/**
 * Base repository class
 *
 * @package Comet\Repositories
 */
abstract class EloquentRepository implements RepositoryInterface, TrashableInterface
{
    /**
     * Specific model instance
     *
     * @var
     */
    protected $model;

    /**
     * Inject the model dependecy
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get all items
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get single item
     *
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
     *
     * @param $data
     * @return mixed Returns new model instance
     */
    public function insert($data)
    {
        $model = null;

        try {
            $model = $this->model->create($data);
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $model;
    }

    /**
     * Update a single item
     *
     * @param $id
     * @param $data
     * @return mixed Returns new model instance
     */
    public function update($id, $data)
    {
        $model = null;

        try {
            $model = $this->model->withTrashed()->find($id);
            $model->update($data);
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $model;
    }

    /**
     * Delete a single item
     *
     * @param $id
     * @returns bool Is the file deleted
     */
    public function delete($id)
    {
        $deleted = false;

        try {
            $deleted = $this->model->find($id)->delete();
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $deleted;
    }

    /**
     * Get only trashed (soft deleted) items
     *
     * @return mixed
     */
    public function getTrash()
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Restore one item from trash
     *
     * @param int $id
     * @return mixed
     */
    public function restoreFromTrash($id)
    {
        return $this->get($id)->restore();
    }

    /**
     * Permanently delete one item from trash
     *
     * @param int $id
     * @return bool
     */
    public function deleteFromTrash($id)
    {
        $removed = false;

        try {
            $this->model->withTrashed()->find($id)->forceDelete();
            $removed = true;
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $removed;
    }

    /**
     * Restore all items
     *
     * @return bool
     */
    public function restoreAll()
    {
        $restored = false;

        try {
            $this->model->onlyTrashed()->restore();
            $restored = true;
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $restored;
    }

    /**
     * Permanently delete all items
     *
     * @return bool
     */
    public function emptyAll()
    {
        $emptied = false;

        try {
            $models = $this->model->onlyTrashed()->get();
            foreach ($models as $model) {
                $this->deleteFromTrash($model->id);
            }
            $emptied = true;
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());
        }

        return $emptied;
    }

    public function getModel()
    {
        return $this->model;
    }
}
