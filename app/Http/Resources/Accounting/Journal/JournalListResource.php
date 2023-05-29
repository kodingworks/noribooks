<?php

namespace App\Http\Resources\Accounting\Journal;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JournalListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->transformCollection($this->collection);

        return [
            'data' => $data,
            // 'amount' => collect($data)->sum('total_debit'),
            'meta' => [
                "success" => true,
                "message" => "Success get journal lists",
                'pagination' => $this->metaData()
            ]
        ];
    }

    private function transformData($data)
    {
        $account = explode(',', $data->account);
        $debit = explode(',', $data->debit);
        $credit = explode(',', $data->credit);  

        $journal_entries = [];
        for ($i = 0; $i < count($account); $i++) {
            $journal_entries[] = [
                'account' => $account[$i],
                'debit' => $debit[$i],
                'credit' => $credit[$i]
            ];
        }

        return [
            'id' => $data->id,
            'date' => $data->date,
            'amount' => $data->amount,
            'description' => $data->description,  
            'amount_formatted' => number_format($data->amount, 2, ',', '.'),
            
        ];

        // return [
        //     'id' => $data->id,
        //     'date' => $data->date,
        //     'description' => $data->description,        
        //     'journal_entry' => [
        //         'id' => $data->journal_entry->id,
        //         'description' => $data->journal_entry->description,
        //         'account_id' => $data->journal_entry->account_id,
        //         'debit' => (int)$data->journal_entry->debit,
        //         'credit' => (int)$data->journal_entry->credit,
        //         'debit_formatted' => number_format($data->journal_entry->debit, 2, ',', '.'),
        //         'credit_formatted' => number_format($data->journal_entry->credit, 2, ',', '.'),
        //     ],
        //     'total_debit' => $data->debit,
        //     'total_debit' => $data->credit,
        //     'total_debit_formatted' => number_format($data->debit, 2, ',', '.'),
        //     'total_debit_formatted' => number_format($data->credit, 2, ',', '.'),
        // ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int)$this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }
}
