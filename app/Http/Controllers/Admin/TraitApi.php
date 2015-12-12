<?php
namespace App\Http\Controllers\Admin;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

trait TraitApi
{
    private $statusCode = 200;
    private $message = null;

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param null $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    private function getFractalManager()
    {
        return new Manager();
    }

    /**
     * Temporary response generator for API calls.
     *
     * @param  mixed $data
     * @param  string $message
     * @param  integer $statusCode
     * @param  string $redirectTo
     * @return mixed
     */
    protected function apiResponse($data, $message = null, $statusCode = 200, $redirectTo = null)
    {
        $json = [
            'data'     => $data,
            'location' => $redirectTo,
            'status'   => $statusCode,
            'message'  => $message
        ];

        return response()->json($json, $statusCode);
    }

    public function respondWithError($msg, $statusCode = 500)
    {
        $this->setStatusCode($statusCode);
        $this->setMessage($msg);

        return $this->respondWithArray([]);
    }

    /**
     * Respond with transformed item
     *
     * @param $item
     * @param $callback
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        $rootScope = $this->getFractalManager()->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond with transformed collection
     *
     * @param $collection
     * @param $callback
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        $rootScope = $this->getFractalManager()->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond with an array of data
     *
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithArray(array $data, $headers = [])
    {
        $data['message'] = $this->message;

        return response()->json($data, $this->statusCode, $headers);
    }
}