<?php

namespace App\Interface;

use App\Models\Api\Post;

interface PostInterface
{
    /**
     * @return mixed
     */
    public function getAllPosts();

    /**
     * @param Post $post
     * @return mixed
     */
    public function getPostById(Post $post);

    /**
     * @param array $data
     * @return mixed
     */
    public function createPost(array $data);

    /**
     * @param Post $post
     * @param array $data
     * @return mixed
     */
    public function updatePost(Post $post, array $data);

    /**
     * @param Post $post
     * @return mixed
     */
    public function deletePost(Post $post);
}
