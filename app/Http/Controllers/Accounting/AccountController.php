<?php

namespace App\Http\Controllers\Accounting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Accounting\Account\AccountService;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\Account\AccountListResource;
use App\Http\Resources\Account\SubmitAccountResource;

class AccountController extends Controller
{
    public function __construct(
        AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index() {
        return Inertia::render('admin/accounting/account/index', [
            "title" => 'Accounting | Chart of Accounts'
        ]);
    }

    public function getData(Request $request) {
        try {
            $data = $this->accountService->getData($request);

            $result = new AccountListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
