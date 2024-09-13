<?php

namespace App\Interface;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

interface RoleInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllRoles(Request $request);

    /**
     * @param array $data
     * @return mixed
     */
    public function createRole(array $data);

    /**
     * @param Role $role
     * @return mixed
     */
    public function getRoleById(Role $role);

    /**
     * @param Role $role
     * @param array $data
     * @return mixed
     */
    public function updateRole(Role $role, array $data);

    /**
     * @param Role $role
     * @return mixed
     */
    public function deleteRole(Role $role);
}
