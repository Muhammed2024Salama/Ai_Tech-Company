<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interface\UserInterface;
use App\Models\Api\User;
use Illuminate\Http\JsonResponse;

class ApiUserController extends Controller
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;

        // Apply Spatie permission middleware
//        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
//        $this->middleware('permission:role-create', ['only' => ['store']]);
//        $this->middleware('permission:role-edit', ['only' => ['update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return ResponseHelper::success(
            'success',
            'Users retrieved successfully',
            UserResource::collection($users)->response()->getData(true)
        );
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userRepository->storeUser($request->validated());
        return ResponseHelper::success(
            'success',
            'User created successfully',
            UserResource::make($user)->response()->getData(true),
            201
        );
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $user = $this->userRepository->getUserById($user->load('posts.comments.user'));
        return ResponseHelper::success(
            'success',
            'User retrieved successfully',
            UserResource::make($user)->response()->getData(true)
        );
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user = $this->userRepository->updateUser($request->validated(), $user);
        return ResponseHelper::success(
            'success',
            'User updated successfully',
            UserResource::make($user)->response()->getData(true)
        );
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->deleteUser($user);
        return ResponseHelper::success(
            'success',
            'User deleted successfully',
            [],
            204
        );
    }
}
