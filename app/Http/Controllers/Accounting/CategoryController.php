<?php

namespace App\Http\Controllers\Accounting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
