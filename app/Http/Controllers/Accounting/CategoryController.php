<?php

namespace App\Http\Controllers\Accounting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Accounting\Category\CategoryListResource;
use App\Http\Resources\Accounting\Category\SubmitCategoryResource;
use App\Http\Requests\Accounting\Category\CreateCategoryRequest;
use App\Http\Requests\Accounting\Category\UpdateCategoryRequest;
use App\Services\Accounting\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index() {
        return Inertia::render('admin/accounting/category/index', [
            "title" => 'Accounting | Category'
        ]);
    }

    public function getData(Request $request)
    {
        try {
            $data = $this->categoryService->getData($request);

            $result = new CategoryListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createData(CreateCategoryRequest $request)
    {
        try {
            $data = $this->categoryService->createData($request);

            $result = new SubmitCategoryResource($data, 'Success Create Category');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function updateData($id, UpdateCategoryRequest $request)
    {
        try {
            $data = $this->categoryService->updateData($id, $request);

            $result = new SubmitCategoryResource($data, 'Success Update Category');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->categoryService->deleteData($id);

            $result = new SubmitCategoryResource($data, 'Success Delete Category');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
