<?php

declare(strict_types=1);

namespace App\Post\Application\Factory;

use App\Post\Domain\Entity\Author;
use App\Post\Domain\Entity\Post;
use Symfony\Component\Uid\Uuid;

class PostFactory
{
    public function __construct(
        private readonly array $allowedTags = ['<ul>', '<li>', '<ol>', '<p>', '<strong>']
    ) {
    }

    public function create(
        string $title,
        string $content,
        Author $author,
        string $imageUrl
    ): Post {
        return new Post(
            Uuid::v4(),
            strip_tags($title, []),
            strip_tags($content, $this->allowedTags),
            $author,
            $imageUrl
        );
    }
}
