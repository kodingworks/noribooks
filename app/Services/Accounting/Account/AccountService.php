<?php

namespace App\Services\Accounting\Account;

use App\Models\Account;
use App\Models\Category;
use App\Services\FileService;
use App\Actions\Utility\PaginateCollection;

class AccountService
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_category = $request->filter_category;
        $sort_by_code = $request->sort_by_code;

        $query = Account::query();

        // Filtering data
        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
        $query->when(request('filter_category', false), function ($q) use ($filter_category) {
            $q->where('category_id', $filter_category);
        });

        // if($sort_by_code){      
        //     if($sort_by_code === 'asc'){
        //         $result = $query->get()->sortBy('category_id');
        //     }else{
        //         $result = $query->get()->sortByDesc('category_id');
        //     }
        //     $paginate = new PaginateCollection();
        //     $result = $paginate->handle($result, 10);
        // }else{
        //     $result = $query->orderBy('id', 'desc')->paginate(10);
        // }

        return $query->paginate(10);

    }

    public function createData($request)
    {
        // Upload the image first
        // $fileService = new FileService();
        // $file = $fileService->uploadFile($request->file('image'));

        // Create the Account after that
        $inputs = $request->only(['name', 'number', 'category_id', 'type', 'description']);
        // $inputs['image'] = $file;
        $Account = Account::create($inputs);

        return $Account;
    }

    public function deleteData($id)
    {
        $Account = Account::findOrFail($id);
        $Account->delete();

        return $Account;
    }

    public function updateData($id, $request)
    {
        // Get Account Data
        $Account = Account::findOrFail($id);
        $file = $Account->image;

        // Upload the image if the new image exists
        if($request->hasFile('image')) {
            $fileService = new FileService();
            $file = $fileService->uploadFile($request->file('image'));
        }

        // Update the Account data
        $inputs = $request->only(['name', 'number', 'category_id', 'type', 'description']);
        $inputs['image'] = $file;
        $Account->update($inputs);

        return $Account;
    }
}
