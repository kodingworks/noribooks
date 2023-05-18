<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;

class ReportService
{
    public function getData($request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $query = Transaction::with(['transaction_details', 'cashier']);

        $query->when(request('start_date', false) && request('end_date', false), function ($q) use ($start_date, $end_date) {
            $q->whereBetween('created_at', [$start_date, $end_date]);
        });

        return $query->paginate(10);
    }

    public function getPdfData($start_date, $end_date)
    {
        $transactions = Transaction::with('cashier')->whereBetween('created_at', [$start_date, $end_date])->get();
        return [
            'transactions' => $transactions,
            'total' => collect($transactions)->sum('grand_total')
        ];
    }
}
