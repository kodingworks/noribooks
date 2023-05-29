<?php

namespace App\Services\Accounting\Journal;

use App\Models\JournalEntry;
use App\Models\Journal;
use App\Models\Account;
use App\Services\FileService;
use App\Actions\Utility\PaginateCollection;

class JournalService
{
    public function getData($request)
    {
        // $search = $request->search;
        // $filter_account = $request->filter_account;
        // $sort_by_code = $request->sort_by_code;

        $query = Journal::query();

        // $query->when(request('search', false), function ($q) use ($search) {
        //     $q->where('name', 'like', '%' . $search . '%');
        // });
        // $query->when(request('filter_account', false), function ($q) use ($filter_account) {
        //     $q->where('account_id', $filter_account);
        // });


        return $query->paginate(10);

    }

    public function getJournalEntries()
    {
        $journalEntries = JournalEntry::get(['id', 'account_id', 'description', 'debit', 'credit',]);

        return $journalEntries;
    }

    public function storeData($request){
        $inputs =  $request->only(['account_id','description' ,'debit','credit']);
        // if ($inputs['payment_status'] === 'paid') {
        //     $inputs['paid_at'] = now()->format('Y-m-d H:i:s');; // Menggunakan waktu saat ini sebagai paid_date
        // } else {
        //     $inputs['paid_at'] = null; // Jika payment_status bukan "paid", set paid_date menjadi null
        // }

        $journal = new Journal();
        $journal->fill($inputs);
        $journal->save();
        $journalID = $journal->id;
        $selectedJournals = $request->input('journal_selected');
        
        foreach($selectedJournals as $account){
              $journalItems = new JournalEntry();
              $journalItems->journal_id = $journalID;
              $journalItems->account_id = intval($account['account_id']);
              $journalItems->debit = $account['debit'];
              $journalItems->credit = $account['credit'];
              $journalItems->amount = $account['amount'];
              $journalItems->save();
        }
  
        return $journal;
     }
    public function createJournalEntry($request)
    {
        $inputs = $request->only(['journal_entry_id', 'date', 'description']);


    }

    public function createData($request)
    {
        // Create the Journal after that
        $inputs = $request->only(['journal_entry_id', 'date', 'description']);
        // $inputs['image'] = $file;
        $Journal = Journal::create($inputs);

        return $Journal;
    }

    // public function deleteData($id)
    // {
    //     $Journal = Journal::findOrFail($id);
    //     $Journal->delete();

    //     return $Journal;
    // }

    // public function updateData($id, $request)
    // {
    //     // Get Journal Data
    //     $Journal = Journal::findOrFail($id);
    //     $file = $Journal->image;

    //     // Upload the image if the new image exists
    //     if($request->hasFile('image')) {
    //         $fileService = new FileService();
    //         $file = $fileService->uploadFile($request->file('image'));
    //     }

    //     // Update the Journal data
    //     $inputs = $request->only(['date', 'account_id', 'description', 'debit', 'credit']);
    //     $inputs['image'] = $file;
    //     $Journal->update($inputs);

    //     return $Journal;
    // }
}
