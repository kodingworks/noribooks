<?php

namespace App\Services\Api\Accounting\Category;

use App\Models\Category;

class CategoryService
{
    public function getCategory()
    {
        $query = Category::query();

        return $query->paginate(10);
    }
}
