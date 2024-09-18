<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Interface\PostInterface;
use App\Models\Api\Post;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\JsonResponse;


class PostController extends Controller
{
    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @param PostInterface $postRepository
     */
    public function __construct(PostInterface $postRepository)
    {
        $this->postRepository = $postRepository;

        // Middleware for permissions
//        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'store']]);
//        $this->middleware('permission:post-create', ['only' => ['store']]);
//        $this->middleware('permission:post-edit', ['only' => ['update']]);
//        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of posts.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->getAllPosts();
        return ResponseHelper::success('success', 'Posts retrieved successfully', PostResource::collection($posts));
    }

    /**
     * Display the specified post.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        $post = $this->postRepository->getPostById($post);
        return ResponseHelper::success('success', 'Post retrieved successfully', new PostResource($post));
    }

    /**
     * Store a newly created post.
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['request'] = $request;

        if (!auth()->check()) {
            return ResponseHelper::error('error', 'Unauthorized. Please log in.', 401);
        }

        $post = $this->postRepository->createPost($data);

        return ResponseHelper::success('success', 'Post created successfully', new PostResource($post), 201);
    }

    /**
     * Update the specified post.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        // dd('knjenfewrkjfnerkfenrwkfwernfwerkfwne');
        $data = $request->validated();
        $data['request'] = $request;

        $post = $this->postRepository->updatePost($post, $data);

        return ResponseHelper::success('success', 'Post updated successfully', new PostResource($post));
    }

    /**
     * Remove the specified post.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->postRepository->deletePost($post);

        return ResponseHelper::success('success', 'Post deleted successfully');
    }
}
