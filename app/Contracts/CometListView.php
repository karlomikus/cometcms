<?php
namespace App\Contracts;

interface CometListView {

    /**
     * Returns paged results for a specific page
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @return mixed
     */
    public function getByPage($page, $limit);

    /**
     * Returns results matching the search term
     *
     * @param $term string Search term
     * @return mixed
     */
    public function search($term);

}