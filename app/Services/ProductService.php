<?php

namespace App\Services;

use App\Models\Product;
use App\Services\FileService;

class ProductService
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_category = $request->filter_category;

        $query = Product::query();

        // Filtering data
        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
        $query->when(request('filter_category', false), function ($q) use ($filter_category) {
            $q->where('category_id', $filter_category);
        });

        return $query->paginate(10);
    }

    public function createData($request)
    {
        // Upload the image first
        $fileService = new FileService();
        $file = $fileService->uploadFile($request->file('image'));

        // Create the product after that
        $inputs = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        $inputs['image'] = $file;
        $product = Product::create($inputs);

        return $product;
    }

    public function deleteData($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $product;
    }

    public function updateData($id, $request)
    {
        // Get Product Data
        $product = Product::findOrFail($id);
        $file = $product->image;

        // Upload the image if the new image exists
        if($request->hasFile('image')) {
            $fileService = new FileService();
            $file = $fileService->uploadFile($request->file('image'));
        }

        // Update the product data
        $inputs = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        $inputs['image'] = $file;
        $product->update($inputs);

        return $product;
    }
}
