<?php

namespace App\Repository;

use App\Interface\RoleInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleRepository implements RoleInterface
{
    public function getAllRoles(Request $request)
    {
        return Role::orderBy('id', 'DESC')->paginate(5);
    }

    public function createRole(array $data)
    {
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'api']);
        $role->syncPermissions($data['permission']);
        return $role;
    }

    public function getRoleById(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return ['role' => $role, 'permissions' => $rolePermissions];
    }

    public function updateRole(Role $role, array $data)
    {
        $role->update([
            'name' => $data['name'],
            'guard_name' => 'api',
        ]);

        $role->syncPermissions($data['permission']);
        return $role;
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
    }
}
