<?php

declare(strict_types=1);

namespace App\Post\Application\Query;

use App\Post\Domain\Entity\Post;
use App\Post\Domain\PostRepository;

class PaginationPost
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    /**
     * @param int $page
     * @param int $limit
     * @return Post[]
     */
    public function getPosts(int $page, int $limit): array
    {
        //TODO add mapping to DTO and cache
        return $this->postRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            $limit,
            ($page - 1) * $limit
        );
    }
}
