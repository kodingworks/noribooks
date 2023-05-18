<?php

namespace App\Services\Accounting\Account;

use App\Models\Account;

class AccountService
{
    public function getData($request)
    {
        $query = Account::paginate(10);

        return $query;
    }  
}
