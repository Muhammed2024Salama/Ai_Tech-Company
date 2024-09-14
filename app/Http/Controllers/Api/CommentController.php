<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Interface\CommentInterface;
use App\Models\Api\Comment;
use App\Models\Api\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentNotification;
use App\Helper\ResponseHelper;

class CommentController extends Controller
{
    /**
     * @var CommentInterface
     */
    protected $commentRepository;

    /**
     * @param CommentInterface $commentRepository
     */
    public function __construct(CommentInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Post $post)
    {
        $comments = $this->commentRepository->getAllCommentsByPost($post);
        return CommentResource::collection($comments);
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return CommentResource|\Illuminate\Http\JsonResponse
     */
    public function show(Post $post, Comment $comment)
    {
        $comment = $this->commentRepository->getCommentById($post, $comment);

        if (!$comment) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        return new CommentResource($comment);
    }

    /**
     * @param CommentRequest $request
     * @param Post $post
     * @return CommentResource
     */
    public function store(CommentRequest $request, Post $post)
    {
        $data = [
            'user_id' => auth()->id(),
            'content' => $request->input('content')
        ];

        $comment = $this->commentRepository->createComment($post, $data);
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
        $comment = $this->commentRepository->updateComment($post, $comment, $request->validated());

        if (!$comment) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        return new CommentResource($comment->load('user'));
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, Comment $comment)
    {
        $deleted = $this->commentRepository->deleteComment($post, $comment);

        if (!$deleted) {
            return response()->json(['message' => 'Comment does not belong to this post'], 403);
        }

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
