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
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return ResponseHelper::success('success', 'Users retrieved successfully', UserResource::collection($users)->response()->getData(true));
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->storeUser($validated);
        return ResponseHelper::success('success', 'User created successfully', UserResource::make($user)->response()->getData(true), 201);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $user = $this->userRepository->getUserById($user);
        return ResponseHelper::success('success', 'User retrieved successfully', UserResource::make($user->load('posts.comments.user'))->response()->getData(true));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->updateUser($validated, $user);
        return ResponseHelper::success('success', 'User updated successfully', UserResource::make($user)->response()->getData(true));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->deleteUser($user);
        return ResponseHelper::success('success', 'User deleted successfully', [], 204);
    }
}
