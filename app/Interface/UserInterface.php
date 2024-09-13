<?php

namespace App\Interface;

use App\Models\Api\User;

interface UserInterface
{
    /**
     * @return mixed
     */
    public function getAllUsers();

    /**
     * @param array $data
     * @return mixed
     */
    public function storeUser(array $data);

    /**
     * @param User $user
     * @return mixed
     */
    public function getUserById(User $user);

    /**
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function updateUser(array $data, User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function deleteUser(User $user);
}
