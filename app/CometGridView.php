<?php
namespace App;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\GridViewInterface;

class CometGridView {

    protected $dataSource;
    private $searchTerm;
    private $sortColumn;
    private $order;
    private $path;

    /**
     * Set up data repository
     *
     * @param $dataSource mixed Data repository
     */
    public function __construct(GridViewInterface $dataSource)
    {
        $this->dataSource = $dataSource;
        $this->sortColumn = 'id';
        $this->order = 'asc';
        $this->searchTerm = null;
        $this->path = null;
    }
    
    public function gridPage($page, $limit)
    {
        $data = $this->dataSource->getByPageGrid($page, $limit, $this->sortColumn, $this->order, $this->searchTerm);

        $paginatedData = new LengthAwarePaginator($data['items'], $data['count'], $limit, $page, ['path' => $this->path]);

        $result['page'] = $page;
        $result['sortColumn'] = $this->sortColumn;
        $result['order'] = $this->order;
        $result['searchTerm'] = $this->searchTerm;
        $result['data'] = $paginatedData;
        $result['totalItems'] = $data['count'];

        return $result;
    }

    public function setSearchTerm($term)
    {
        $this->searchTerm = $term;
    }

    public function setSortColumn($sortColumn)
    {
        $this->sortColumn = $sortColumn;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

}