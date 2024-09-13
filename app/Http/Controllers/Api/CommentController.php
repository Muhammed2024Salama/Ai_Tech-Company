<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Api\Comment;
use App\Models\Api\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentNotification;
use App\Helper\ResponseHelper;

class CommentController extends Controller
{
    /**
     * @param Post $post
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Post $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return CommentResource|\Illuminate\Http\JsonResponse
     */
    public function show(Post $post, Comment $comment)
    {
        // تحقق أن التعليق ينتمي للمنشور
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        return new CommentResource($comment->load('user'));
    }

    /**
     * @param CommentRequest $request
     * @param Post $post
     * @return CommentResource
     */
    public function store(CommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input("content"),
        ]);

        return new CommentResource($comment->load('user'));
    }

    /**
     * @param CommentRequest $request
     * @param Post $post
     * @param Comment $comment
     * @return CommentResource|\Illuminate\Http\JsonResponse
     */
    public function update(CommentRequest $request, Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        $comment->update($request->validated());

        return new CommentResource($comment->load('user'));
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
