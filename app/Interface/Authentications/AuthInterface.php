<?php

namespace App\Interface\Authentications;

use App\Models\User;

interface AuthInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User;

    /**
     * @param array $credentials
     * @return User|null
     */
    public function login(array $credentials): ?User;

    /**
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * @return bool
     */
    public function logout(): bool;
}
