<?php

namespace App\Repository;

use App\Interface\RoleInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleRepository implements RoleInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllRoles(Request $request)
    {
        return Role::orderBy('id', 'DESC')->paginate(5);
    }

    /**
     * @param array $data
     * @return \Spatie\Permission\Contracts\Role|Role
     */
    public function createRole(array $data)
    {
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'api']);
        $role->syncPermissions($data['permission']);
        return $role;
    }

    /**
     * @param Role $role
     * @return array
     */
    public function getRoleById(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return ['role' => $role, 'permissions' => $rolePermissions];
    }

    /**
     * @param Role $role
     * @param array $data
     * @return Role
     */
    public function updateRole(Role $role, array $data)
    {
        $role->update([
            'name' => $data['name'],
            'guard_name' => 'api',
        ]);

        $role->syncPermissions($data['permission']);
        return $role;
    }

    /**
     * @param Role $role
     * @return void
     */
    public function deleteRole(Role $role)
    {
        $role->delete();
    }
}
