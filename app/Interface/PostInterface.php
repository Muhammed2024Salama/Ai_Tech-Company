<?php

namespace App\Interface;

use App\Models\Api\Post;

interface PostInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPosts();

    /**
     * @param Post $post
     * @return Post
     */
    public function getPostById(Post $post);

    /**
     * @param array $data
     * @return Post
     */
    public function createPost(array $data);

    /**
     * @param Post $post
     * @param array $data
     * @return Post
     */
    public function updatePost(Post $post, array $data);

    /**
     * @param Post $post
     * @return void
     */
    public function deletePost(Post $post);
}
