<?php

declare(strict_types=1);

namespace App\Post\Domain;

use App\Post\Domain\Entity\Post;
use Symfony\Component\Uid\Uuid;

interface PostRepository
{
    /**
     * @param Post $post
     * @return void
     */
    public function save(Post $post): void;

    /**
     * @param Uuid $postUuid
     * @return Post
     */
    public function get(Uuid $postUuid): Post;

    /**
     * @param Post $post
     * @return void
     */
    public function delete(Post $post): void;

    /**
     * @param Uuid $postUuid
     * @return void
     */
    public function deleteById(Uuid $postUuid): void;
}
