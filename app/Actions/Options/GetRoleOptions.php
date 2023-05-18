<?php

namespace App\Actions\Options;

use App\Models\Role;


class GetRoleOptions
{
    public function handle()
    {
        $role = Role::pluck('name', 'id');

        return $role;
    }
}
