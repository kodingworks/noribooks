<?php

namespace App\Services\Accounting\Category;

use App\Models\Category;

class CategoryService
{
    public function getData($request)
    {
        $search = $request->search;

        $query = Category::query();

        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->paginate(10);
    }

    public function createData($request)
    {
        $inputs = $request->only(['code','name' ]);
        $category = Category::create($inputs);

        return $category;
    }

    public function deleteData($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $category;
    }

    public function updateData($id, $request)
    {
        $inputs = $request->only(['code','name' ]);
        
        $category = Category::findOrFail($id);
        $category->update($inputs);

        return $category;
    }
}
