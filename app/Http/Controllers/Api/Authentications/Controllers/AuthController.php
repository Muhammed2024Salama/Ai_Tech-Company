<?php

namespace App\Http\Controllers\Api\Authentications\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Api\Authentications\Requests\LoginRequest;
use App\Http\Controllers\Api\Authentications\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Interface\Authentications\AuthInterface;
use Exception;

class AuthController extends Controller
{
    /**
     * @var AuthInterface
     */
    protected AuthInterface $authRepository;

    /**
     * @param AuthInterface $authRepository
     */
    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authRepository->register($request->all());

            return ResponseHelper::success(
                message: 'User has been Registered Successfully !',
                data: $user,
                statusCode: 201
            );
        } catch (Exception $e) {
            \Log::error('Unable to Register User : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Register user, Please try again !' . $e->getMessage(),
                statusCode: 500
            );
        }
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authRepository->login($request->only('email', 'password'));

            if (!$user) {
                return ResponseHelper::error(
                    message: 'Unable To Login! Invalid credentials.',
                    statusCode: 400
                );
            }

            // Generate a token for the user
            $token = $user->createToken('My Api Token')->plainTextToken;
            $authUser = ['user' => $user, 'token' => $token];

            return ResponseHelper::success(
                message: 'You are logged in successfully!',
                data: $authUser,
                statusCode: 200
            );
        } catch (Exception $e) {
            \Log::error('Unable to login user: ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable to login! Please try again! ' . $e->getMessage(),
                statusCode: 500
            );
        }
    }

    /**
     * @return mixed
     */
    public function userProfile()
    {
        try {
            $user = $this->authRepository->getUser();
            if ($user) {
                return ResponseHelper::success(
                    message: 'User Profile Fetched Successfully !',
                    data: $user,
                    statusCode: 200
                );
            }

            return ResponseHelper::error(
                message: 'Unable to fetch user data! Invalid token.',
                statusCode: 400
            );
        } catch (Exception $e) {
            \Log::error('Unable To Fetch User Profile Data: ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Fetch User Profile Data ! Please try again !' . $e->getMessage(),
                statusCode: 500
            );
        }
    }

    /**
     * @return mixed
     */
    public function userLogout()
    {
        try {
            $result = $this->authRepository->logout();

            if ($result) {
                return ResponseHelper::success(
                    message: 'User Logged out Successfully !',
                    statusCode: 200
                );
            }

            return ResponseHelper::error(
                message: 'Unable to log out! Invalid token.',
                statusCode: 400
            );
        } catch (Exception $e) {
            \Log::error('Unable To Logout Due to some exception: ' . $e->getMessage() . ' - Line no. ' . $e->getLine());

            return ResponseHelper::error(
                message: 'Unable To Logout Due to some exception ! Please try again !' . $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
