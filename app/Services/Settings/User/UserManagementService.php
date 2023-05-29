<?php

namespace App\Services\Settings\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementService
{
    public function getData($request)
    {
        $search = $request->search;

        $query = User::query();

        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->paginate(10);
    }

    public function createData($request)
    {
        $inputs = $request->only(['name', 'email']);
        $inputs['password'] = Hash::make($request->password);

        $user = User::create($inputs);

        // Assign role after create user
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role->name);

        return $user;
    }

    public function deleteData($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    public function updateData($id, $request)
    {
        $user = User::findOrFail($id);

        $inputs = $request->only(['name', 'email']);
        $inputs['password'] = $request->password ? Hash::make($request->password) : $user->password;
        $user->update($inputs);

        // Sync role after update user
        $role = Role::findOrFail($request->role_id);
        $user->syncRoles($role->name);

        return $user;
    }
}
