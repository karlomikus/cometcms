<?php
namespace App\Libraries\GridView;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Libraries\GridView\GridViewInterface;
use PhpSpec\Exception\Exception;

/**
 * Grid View
 *
 * @package App\Libraries\GridView
 */
class GridView {

    /**
     * @var \App\Libraries\GridView\GridViewInterface
     */
    protected $dataSource;
    /**
     * @var null
     */
    private $searchTerm;
    /**
     * @var string
     */
    private $sortColumn;
    /**
     * @var string
     */
    private $order;
    /**
     * @var null
     */
    private $path;
    /**
     * @var bool
     */
    private $trash;

    /**
     * Set up data repository. Data repository must implement GridViewInterface.
     *
     * @param GridViewInterface $dataSource Data repository
     * @param bool $getOnlyTrashed
     * @throws Exception
     */
    public function __construct(GridViewInterface $dataSource, $getOnlyTrashed = false)
    {
        if (!($dataSource instanceof GridViewInterface)) {
            throw new Exception('Data repository must implement GridViewInterface');
        }

        $this->dataSource = $dataSource;
        $this->sortColumn = 'id';
        $this->order = 'asc';
        $this->searchTerm = null;
        $this->path = null;
        $this->trash = $getOnlyTrashed;
    }

    /**
     * Returns an array of paged data limited by $limit parameter.
     *
     * @param $page int Current page number
     * @param $limit int Limit of records per page
     * @return array
     */
    public function gridPage($page, $limit)
    {
        $data = $this->dataSource->getByPageGrid($page, $limit, $this->sortColumn, $this->order, $this->searchTerm, $this->trash);

        $paginatedData = new LengthAwarePaginator($data['items'], $data['count'], $limit, $page, ['path' => $this->path]);

        $result['page'] = $page;
        $result['sortColumn'] = $this->sortColumn;
        $result['order'] = $this->order;
        $result['searchTerm'] = $this->searchTerm;
        $result['data'] = $paginatedData;
        $result['totalItems'] = $data['count'];
        $result['rowsLimit'] = $paginatedData->count();

        $result['headerAttr'] = [
            'page'   => $page,
            'column' => $this->sortColumn,
            'order'  => $this->order,
            'search' => $this->searchTerm
        ];

        return $result;
    }

    /**
     * @param $term
     */
    public function setSearchTerm($term)
    {
        $this->searchTerm = $term;
    }

    /**
     * @param $sortColumn
     * @param null $default
     */
    public function setSortColumn($sortColumn, $default = null)
    {
        if (!isset($sortColumn)) {
            $this->sortColumn = $default;
        }
        else {
            $this->sortColumn = $sortColumn;
        }
    }

    /**
     * @param $order
     * @param null $default
     */
    public function setOrder($order, $default = null)
    {
        if (!isset($order)) {
            $this->order = $default;
        }
        else {
            $this->order = $order;
        }
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

}