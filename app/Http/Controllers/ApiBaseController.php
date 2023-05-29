<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    public function exceptionError($exception, $status = 400)
    {
        return response()->json([
            'meta' => [
                "success" => false,
                'error' => is_array($exception) ? $exception : $exception
            ]
        ], $status);
    }

    public function messageSuccess($message = "Success", $status = 200)
    {
        return response()->json([
            'meta' => [
                "success" => true,
                'message' => $message
            ]
        ], $status);
    }

    public function emptyDataSuccess($message = "Success", $status = 200)
    {
        return response()->json([
            'data' => (object)[],
            'meta' => [
                'success' => true,
                'message' => $message,
                'pagination' => (object)[],
            ],
        ], $status);
    }

    /**
     * Returns a 200 response.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function respond($data)
    {
        return response()->json($data);
    }

    /**
     * Paginate from array
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function paginate($data, $per_page = 5, $options = null)
    {
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($data);

        //Slice the collection to get the items to display in current page
        $currentPageResults = $collection->slice(($currentPage - 1) * $per_page, $per_page)->values();

        //Create our paginator and add it to the data array
        $data['results'] = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);


        return $data['results']->setPath(url()->current() . '?' . http_build_query(['per_page' => $per_page]));
    } 
}
