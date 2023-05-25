<?php

namespace App\Http\Controllers\Accounting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Accounting\Account\AccountService;
use App\Actions\Options\GetCategoryOptions;
use App\Http\Requests\Accounting\Account\CreateAccountRequest;
use App\Http\Requests\Accounting\Account\UpdateAccountRequest;
use App\Http\Resources\Accounting\Account\AccountListResource;
use App\Http\Resources\Accounting\Account\SubmitAccountResource;

class AccountController extends Controller
{
    public function __construct(
        AccountService $accountService, GetCategoryOptions $getCategoryOptions)
    {
        $this->accountService = $accountService;
        $this->getCategoryOptions = $getCategoryOptions;
    }

    public function index() {
        return Inertia::render('admin/accounting/account/index', [
            "title" => 'Accounting | Chart of Accounts',
            "additional" => [
                'category_list' => $this->getCategoryOptions->handle(),
                'category_list_code' => $this->getCategoryOptions->codeHandle()
            ]
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

    
    public function createData(CreateAccountRequest $request)
    {
        try {
            $data = $this->accountService->createData($request);

            $result = new SubmitAccountResource($data, 'Success Create Account');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    
    public function updateData($id, UpdateAccountRequest $request)
    {
        try {
            $data = $this->accountService->updateData($id, $request);

            $result = new SubmitAccountResource($data, 'Success Update Account');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->accountService->deleteData($id);

            $result = new SubmitAccountResource($data, 'Success Delete Account');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
