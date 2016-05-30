<?php
namespace Comet\Core\Services;

use Comet\Core\Models\Opponent;
use Comet\Core\Extensions\GridView\GridView;
use Comet\Core\Extensions\GridView\EloquentGridViewAdapter;
use Comet\Core\Contracts\Repositories\OpponentsRepositoryInterface as Opponents;

/**
 * Opponents Service
 */
class OpponentService
{
    private $opponents;

    /**
     * @param Opponents $opponents
     */
    public function __construct(Opponents $opponents)
    {
        $this->opponents = $opponents;
    }

    /**
     * Get all opponents
     *
     * @return Collectiopn
     */
    public function getOpponents()
    {
        return $this->opponents->all();
    }

    /**
     * Get a single opponent
     *
     * @param  int $id
     * @return Opponent
     */
    public function getOpponent($id)
    {
        return $this->opponents->get($id);
    }

    /**
     * Render a grid view table
     *
     * @param  array $options
     * @return string
     */
    public function getGridView(array $options)
    {
        // Get data
        $resolver = new EloquentGridViewAdapter(Opponent::class);
        $resolver->order($options['order'], $options['direction']);
        $resolver->filter(['name', 'description'], $options['search']);

        // Create grid
        $grid = new GridView($resolver, $options['page'], $options['limit']);
        $grid->setBasePath('/admin/opponents');

        // Setup columns
        $colName = $grid->setColumn('Name', 'name');
        $colDesc = $grid->setColumn('Description', 'desc');
        $grid->setColumn('', 'action');

        // Setup header links
        $grid->setHeader($colName, 'name');
        $grid->setHeader($colDesc, 'description');

        // Assign data
        $grid->assignAttribute('name', function ($row) {
            return '<a href="/admin/opponents/edit/'. $row->id .'">'. $row->name .'<a>';
        });
        $grid->assignAttribute('desc', 'description');
        $grid->assignAttribute('action', function ($row) {
            return '<a href="/admin/opponents/trash/'. $row->id .'"  class="text-delete">Trash<a>';
        });

        // Render grid
        return $grid->make('opponents');
    }
}
