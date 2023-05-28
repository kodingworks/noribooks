<?php

namespace App\Actions\Options;

use App\Models\Account;


class GetAccountOptions
{
    public function handle()
    {
        $account = Account::pluck('name',  'id');

        return $account;
    }
}
