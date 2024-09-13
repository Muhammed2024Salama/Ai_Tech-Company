<?php

namespace App\Repository;

use App\Interface\UserInterface;
use App\Models\Api\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return User::latest()->paginate(5);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function storeUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($data['roles']);
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function getUserById(User $user)
    {
        return $user;
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function updateUser(array $data, User $user)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }

        $user->update($data);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($data['roles']);

        return $user;
    }

    /**
     * @param User $user
     * @return true
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return true;
    }
}
