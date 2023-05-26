<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Accounting\Journal\JournalListResource;
use App\Services\Accounting\Journal\JournalService;
use Inertia\Inertia;

class JournalController extends Controller
{
    public function __construct(
        JournalService $JournalService)
    {
        $this->JournalService = $JournalService;
    }

    public function index() {
        return Inertia::render('admin/accounting/journal/index', [
            "title" => 'Accounting | Manual Journal'
        ]);
    }

    public function createPage()
    {
      
        return Inertia::render('admin/accounting/journal/create', [
            "title" => 'Accounting | Journal Entry',
        ]);

    }


    public function getData(Request $request)
    {
        try {
            $data = $this->JournalService->getData($request);

            $result = new JournalListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
