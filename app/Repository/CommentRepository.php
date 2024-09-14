<?php

namespace App\Repository;

use App\Interface\CommentInterface;
use App\Models\Api\Comment;
use App\Models\Api\Post;

class CommentRepository implements CommentInterface
{
    /**
     * @param Post $post
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllCommentsByPost(Post $post)
    {
        return $post->comments()->with('user')->get();
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return Comment|mixed|null
     */
    public function getCommentById(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return null;
        }

        return $comment->load('user');
    }

    /**
     * @param Post $post
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function createComment(Post $post, array $data)
    {
        return $post->comments()->create($data);
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @param array $data
     * @return Comment|null
     */
    public function updateComment(Post $post, Comment $comment, array $data)
    {
        if ($comment->post_id !== $post->id) {
            return null;
        }

        $comment->update($data);
        return $comment;
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return bool|mixed|null
     */
    public function deleteComment(Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            return false;
        }

        return $comment->delete();
    }
}
