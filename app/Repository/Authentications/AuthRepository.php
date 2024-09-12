<?php

namespace App\Repository\Authentications;

use App\Interface\Authentications\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'email_verified_at' => now(),
        ]);
    }

    /**
     * @param array $credentials
     * @return User|null
     */
    public function login(array $credentials): ?User
    {
//        dd($credentials);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return Auth::user();
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        $user = Auth::user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return true;
        }
        return false;
    }
}
