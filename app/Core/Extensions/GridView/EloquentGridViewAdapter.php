<?php
namespace Comet\Core\Extensions\GridView;

use Comet\Core\Extensions\GridView\Contracts\GridViewAdapter;

/**
 * Adapter for eloquent grid view
 */
class EloquentGridViewAdapter implements GridViewAdapter
{
    /**
     * Eloquent model
     *
     * @var $model
     */
    private $model;

    /**
     * Create new eloquent grid
     *
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = (new $model)->newQuery();
    }

    /**
     * Filter the query
     *
     * @param  array|string $cols
     * @param  string $val
     * @return Model
     */
    public function filter($cols, $val)
    {
        if (!isset($val)) {
            return;
        }

        if (is_array($cols)) {
            foreach ($cols as $col) {
                $this->model->where($col, 'LIKE', '%' . $val . '%');
            }
        }
        else {
            $this->model->where($cols, 'LIKE', '%' . $val . '%');
        }

        return $this;
    }

    /**
     * Order query results
     *
     * @param  string $col
     * @param  string $direction
     * @return Model
     */
    public function order($col, $direction)
    {
        $this->model->orderBy($col, $direction);

        return $this;
    }

    /**
     * Chunk the results by pages
     *
     * @param  int $page
     * @param  int $limit
     * @return Collection
     */
    public function chunk($page, $limit)
    {
        return $this->model->skip($limit * ($page - 1))->take($limit)->get();
    }

    /**
     * Get the total number of rows in a query
     *
     * @return int
     */
    public function total()
    {
        //echo '::' . $this->model->count() . '::';
        return $this->model->count();
    }
}
