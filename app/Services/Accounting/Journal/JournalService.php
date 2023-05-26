<?php

namespace App\Services\Accounting\Journal;

use App\Models\Account;
use App\Models\Journal;
use App\Services\FileService;
use App\Actions\Utility\PaginateCollection;

class JournalService
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_account = $request->filter_account;
        $sort_by_code = $request->sort_by_code;

        $query = Journal::query();

        // Filtering data
        // $query->when(request('search', false), function ($q) use ($search) {
        //     $q->where('name', 'like', '%' . $search . '%');
        // });
        // $query->when(request('filter_account', false), function ($q) use ($filter_account) {
        //     $q->where('account_id', $filter_account);
        // });


        return $query->paginate(10);

    }

    // public function getJournalEntries()
    // {
    //     $permissions = Permission::get(['id', 'name', 'guard_name', 'label', 'group', 'sub_group'])->groupBy(['group', 'sub_group']);

    //     return $permissions;
    // }

    public function createData($request)
    {
        // Upload the image first
        // $fileService = new FileService();
        // $file = $fileService->uploadFile($request->file('image'));

        // Create the Journal after that
        $inputs = $request->only(['date', 'account_id', 'description', 'amount']);
        // $inputs['image'] = $file;
        $Journal = Journal::create($inputs);

        return $Journal;
    }

    public function deleteData($id)
    {
        $Journal = Journal::findOrFail($id);
        $Journal->delete();

        return $Journal;
    }

    public function updateData($id, $request)
    {
        // Get Journal Data
        $Journal = Journal::findOrFail($id);
        $file = $Journal->image;

        // Upload the image if the new image exists
        if($request->hasFile('image')) {
            $fileService = new FileService();
            $file = $fileService->uploadFile($request->file('image'));
        }

        // Update the Journal data
        $inputs = $request->only(['date', 'account_id', 'description', 'debit', 'credit']);
        $inputs['image'] = $file;
        $Journal->update($inputs);

        return $Journal;
    }
}
