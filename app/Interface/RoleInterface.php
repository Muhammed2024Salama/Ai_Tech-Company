<?php

namespace App\Interface;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

interface RoleInterface
{
    public function getAllRoles(Request $request);
    public function createRole(array $data);
    public function getRoleById(Role $role);
    public function updateRole(Role $role, array $data);
    public function deleteRole(Role $role);
}
