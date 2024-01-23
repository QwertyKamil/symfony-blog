<?php

declare(strict_types=1);

namespace App\Post\Domain;

interface PostRepositoryInterface
{
    /**
     * @param Post $post
     * @return void
     */
    public function save(Post $post): void;

    /**
     * @param PostId $postId
     * @return Post
     */
    public function get(PostId $postId): Post;

    /**
     * @param Post $post
     * @return void
     */
    public function delete(Post $post): void;

    /**
     * @param PostId $postId
     * @return void
     */
    public function deleteById(PostId $postId): void;

    public function find($id, $lockMode = null, $lockVersion = null);
}
