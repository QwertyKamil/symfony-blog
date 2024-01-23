<?php

declare(strict_types=1);

namespace App\Post\Domain;

class Post
{
    public function __construct(
        private PostId $id,
        private string $title,
        private string $content,
        private Author $author,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
    ) {
    }
}
