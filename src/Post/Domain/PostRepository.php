<?php

declare(strict_types=1);

namespace App\Post\Domain;

use App\Post\Domain\Entity\Post;
use Symfony\Component\Uid\Uuid;

interface PostRepository
{
    public function save(Post $post): void;

    public function get(Uuid $postUuid): Post;

    public function delete(Post $post): void;

    public function deleteById(Uuid $postUuid): void;
}
