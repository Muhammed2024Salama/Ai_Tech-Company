<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Api\Post;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\JsonResponse;


class PostController extends Controller
{
    use ImageUploadTrait;

    /**
     * @return mixed
     */
    public function index()
    {
        $posts = Post::all();
        return ResponseHelper::success('success', 'Posts retrieved successfully', $posts);
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function show(Post $post)
    {
        return ResponseHelper::success('success', 'Post retrieved successfully', $post);
    }

    /**
     * @param PostRequest $request
     * @return mixed
     */
    public function store(PostRequest $request)
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Check if a user is authenticated
        if (!$userId) {
            return ResponseHelper::error('error', 'Unauthorized. Please log in.', 401);
        }

        $imagePath = $this->uploadImage($request, 'image', 'uploads/posts');

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->input("content"),
            'image' => $imagePath,
            'status' => $request->status,
            'published_at' => $request->published_at ?? now(),
            'user_id' => $userId, // Assign the authenticated user ID
        ]);

        return ResponseHelper::success('success', 'Post created successfully', $post, 201);
    }

    /**
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return mixed
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $imagePath = $this->updateImage($request, 'image', 'uploads/posts', $post->image);

        $post->update([
            'title' => $request->title,
            'content' => $request->input("content"),
            'image' => $imagePath ?? $post->image,
            'published_at' => $request->published_at ?? now(),
            'status' => $request->status,
        ]);

        return ResponseHelper::success('success', 'Post updated successfully', $post);
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function destroy(Post $post)
    {
        $this->deleteImage($post->image);
        $post->delete();

        return ResponseHelper::success('success', 'Post deleted successfully');
    }
}
