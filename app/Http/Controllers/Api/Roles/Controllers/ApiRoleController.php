<?php

namespace App\Http\Controllers\Api\Roles\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Interface\RoleInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiRoleController extends Controller
{
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @param RoleInterface $roleRepository
     */
    public function __construct(RoleInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $roles = $this->roleRepository->getAllRoles($request);
        return ResponseHelper::success('success', 'Roles retrieved successfully', RoleResource::collection($roles));
    }

    /**
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $role = $this->roleRepository->createRole($validated);
        return ResponseHelper::success('success', 'Role created successfully', new RoleResource($role), 201);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        $roleData = $this->roleRepository->getRoleById($role);
        return ResponseHelper::success('success', 'Role retrieved successfully', [
            'role' => new RoleResource($roleData['role']),
            'permissions' => $roleData['permissions'],
        ]);
    }

    /**
     * @param StoreRoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(StoreRoleRequest $request, Role $role): JsonResponse
    {
        $validated = $request->validated();
        $updatedRole = $this->roleRepository->updateRole($role, $validated);
        return ResponseHelper::success('success', 'Role updated successfully', new RoleResource($updatedRole));
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->roleRepository->deleteRole($role);
        return ResponseHelper::success('success', 'Role deleted successfully', null, 204);
    }
}
