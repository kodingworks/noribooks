<?php

namespace App\Services\Settings\Role;

use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagementService
{
    public function getData($request)
    {
        $search = $request->search;

        // Get company
        $query = Role::query();

        // Filter By Params
        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->paginate(10);
    }

    public function getPermissionList()
    {
        $permissions = Permission::get(['id', 'name', 'guard_name', 'label', 'group', 'sub_group'])->groupBy(['group', 'sub_group']);

        return $permissions;
    }

    public function findRoleById($id)
    {
        $role = Role::findOrFail($id);
        return $role;
    }

    public function getRoleHasPermissions($id)
    {
        $role = Role::findOrFail($id);
        return $role->getAllPermissions()->pluck('id');
    }

    public function storeData($request)
    {
        // Create a role first 
        $roleInput = $request->only(['role_name']);
        $role = Role::create([
            'name' => $roleInput['role_name']
        ]);

        // Assign Permission To a New Role
        $permissions = collect($request->permissions)->where('status', true)->all();
        $role->syncPermissions($permissions);
        
        return true;
    }

    public function updateData($id, $request)
    {
        // update role
        $role = $this->findRoleById($id);
        $role->update([
            'name' => $request->role_name
        ]);

        // Sync New Permissions
        $permissions = collect($request->permissions)->where('status', true)->all();
        $role->syncPermissions($permissions);

        return true;
    }

    public function deleteData($id)
    {
        $role = $this->findRoleById($id);
        $role->delete();

        return $role;
    }
}