<?php
namespace App\Contracts;

interface GridViewInterface {

    /**
     * Returns paged results for a specific page
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @param $sortColumn string Column name
     * @param $searchTerm string Search term
     * @return array
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null);

}