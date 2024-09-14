<?php

namespace App\Repository;

use App\Interface\PostInterface;
use App\Models\Api\Post;
use App\Traits\ImageUploadTrait;

class PostRepository implements PostInterface
{

    use ImageUploadTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllPosts()
    {
        return Post::all();
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function getPostById(Post $post)
    {
        return $post;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createPost(array $data)
    {
        $data['image'] = $this->uploadImage($data['request'], 'image', 'uploads/posts');
        $data['user_id'] = auth()->id();
        $data['published_at'] = $data['published_at'] ?? now();

        return Post::create($data);
    }

    /**
     * @param Post $post
     * @param array $data
     * @return Post
     */
    public function updatePost(Post $post, array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->updateImage($data['request'], 'image', 'uploads/posts', $post->image);
        }
        $data['published_at'] = $data['published_at'] ?? now();

        $post->update($data);
        return $post;
    }

    /**
     * @param Post $post
     * @return void
     */
    public function deletePost(Post $post)
    {
        $this->deleteImage($post->image);
        $post->delete();
    }
}
