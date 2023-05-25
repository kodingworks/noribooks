<?php

namespace App\Http\Controllers\Api\Accounting\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController;
use App\Services\Api\Accounting\Category\CategoryService;
use App\Http\Resources\Api\Accounting\Category\CategoryListResource;

class CategoryController extends ApiBaseController
{
    public function __construct(CategoryService $service)
    {
        $this->categoryService = $service;
    }

    public function getCategory(Request $request)
    {
        try {
            $data = $this->categoryService->getCategory($request);

            $return = new CategoryListResource($data, 'Success Get Category');
            return $this->respond($return);
        } catch (\Throwable $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
    
}
