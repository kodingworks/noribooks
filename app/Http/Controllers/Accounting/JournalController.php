<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\Journal\CreateJournalRequest;
use App\Http\Resources\Accounting\Journal\JournalListResource;
use App\Http\Resources\Accounting\Journal\SubmitJournalResource;
use App\Services\Accounting\Journal\JournalService;
use App\Actions\Options\GetAccountOptions;
use Inertia\Inertia;

class JournalController extends Controller
{
    public function __construct(
        JournalService $journalService, GetAccountOptions $getAccountOptions)
    {
        $this->journalService = $journalService;
        $this->getAccountOptions = $getAccountOptions;
    }

    public function index() {
        return Inertia::render('admin/accounting/journal/index', [
            "title" => 'Accounting | Manual Journal'
        ]);
    }

    public function createJournalPage()
    {
      
        return Inertia::render('admin/accounting/journal/create', [
            "title" => 'Accounting | Journal Entry',
            "additional" => [
                'account_list' => $this->getAccountOptions->handle(),
                'journal_list' => $this->journalService->getJournalEntries(),
            ]
        ]);

    }

    public function getData(Request $request)
    {
        try {
            $data = $this->journalService->getData($request);

            $result = new JournalListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createData(CreateJournalRequest $request)
    {
        try {
            $data = $this->journalService->createData($request);

            $result = new SubmitJournalResource($data, 'Success Create New Journal');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    // public function createOrder(CreateOrderRequest $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $data = $this->transactionService->payOrder($request);
    //         $result = new SubmitOrderResource($data, 'Success Create Order');
    //         DB::commit();
            
    //         return $this->respond($result);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return $this->exceptionError($e->getMessage());
    //     }
    // }

}
