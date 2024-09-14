<?php

namespace App\Interface;

use App\Models\Api\Comment;
use App\Models\Api\Post;

interface CommentInterface
{
    /**
     * @param Post $post
     * @return mixed
     */
    public function getAllCommentsByPost(Post $post);

    /**
     * @param Post $post
     * @param Comment $comment
     * @return mixed
     */
    public function getCommentById(Post $post, Comment $comment);

    /**
     * @param Post $post
     * @param array $data
     * @return mixed
     */
    public function createComment(Post $post, array $data);

    /**
     * @param Post $post
     * @param Comment $comment
     * @param array $data
     * @return mixed
     */
    public function updateComment(Post $post, Comment $comment, array $data);

    /**
     * @param Post $post
     * @param Comment $comment
     * @return mixed
     */
    public function deleteComment(Post $post, Comment $comment);
}
