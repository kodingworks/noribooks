<?php

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\Role\RoleManagementService;
use App\Http\Requests\Settings\Role\CreateRoleRequest;
use App\Http\Requests\Settings\Role\UpdateRoleRequest;
use App\Http\Resources\Settings\Role\SubmitRoleResource;
use App\Http\Resources\Settings\Role\RoleManagementListResource;

class RoleManagementController extends Controller
{
    public function __construct(RoleManagementService $roleManagementService)
    {
        $this->roleManagementService = $roleManagementService;
    }

    public function index()
    {
        return Inertia::render('admin/settings/role/index', [
            "title" => 'Accounting | Role managements'
        ]);
    }

    public function getRoleList(Request $request)
    {
        try {
            $data = $this->roleManagementService->getData($request);

            $result = new RoleManagementListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createRolePage()
    {
        return Inertia::render('admin/settings/role/create', [
            "title" => 'Accounting | Role managements',
            "additional" => [
                'permission_list' => $this->roleManagementService->getPermissionList()
            ]
        ]);
    }

    public function editRolePage($id)
    {
        return Inertia::render('admin/settings/role/edit', [
            "title" => 'Accounting | Role managements',
            "additional" => [
                'permission_list' => $this->roleManagementService->getPermissionList(),
                'role' => $this->roleManagementService->findRoleById($id),
                'role_has_permissions' => $this->roleManagementService->getRoleHasPermissions($id)
            ]
        ]);
    }

    public function storeNewRole(CreateRoleRequest $request)
    {
        try {
            $data = $this->roleManagementService->storeData($request);

            $result = new SubmitRoleResource($data, 'Success Create New Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function updateRole($id, UpdateRoleRequest $request)
    {
        try {
            $data = $this->roleManagementService->updateData($id, $request);

            $result = new SubmitRoleResource($data, 'Success Update Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteRole($id)
    {
        try {
            $data = $this->roleManagementService->deleteData($id);

            $result = new SubmitRoleResource($data, 'Success Delete Role');
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
