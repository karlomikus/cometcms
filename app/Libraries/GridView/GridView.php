<?php
namespace App\Libraries\GridView;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
    public function __construct($dataSource, $getOnlyTrashed = false)
    {
        if (!($dataSource instanceof GridViewInterface)) {
            throw new Exception('Data repository must implement GridViewInterface');
        }

        $this->dataSource = $dataSource;
        $this->trash = $getOnlyTrashed;
    }

    /**
     * Returns an array of paged data limited by $limit parameter.
     *
     * @param $limit int Limit of records per page
     * @return array
     */
    public function gridPage($limit)
    {
        $request = Request::capture();

        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');
        $path = $request->getPathInfo();

        $data = $this->dataSource->getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm, $this->trash);

        $paginatedData = new LengthAwarePaginator($data['items'], $data['count'], $limit, $page, ['path' => $path]);

        $result['page'] = $page;
        $result['sortColumn'] = $sortColumn;
        $result['order'] = $order;
        $result['searchTerm'] = $searchTerm;
        $result['data'] = $paginatedData;
        $result['totalItems'] = $data['count'];
        $result['rowsLimit'] = $paginatedData->count();

        $result['headerAttr'] = [
            'page'   => $page,
            'column' => $sortColumn,
            'order'  => $order,
            'search' => $searchTerm
        ];

        return $result;
    }

}