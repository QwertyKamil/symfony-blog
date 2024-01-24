<?php

declare(strict_types=1);

namespace App\Post\UI\ViewModel;

use App\Post\Domain\Entity\Post;
use App\Post\Infrastructure\Persistence\Doctrine\PostRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostList
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    /**
     * @param array $posts
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPostsPaginated(array $posts, int $page, int $limit): array
    {
        $total = $this->postRepository->count([]);

        $nextPage = $page + 1;
        $prevPage = $page - 1;

        return [
            'items' => array_map(
                function ($post) {
                    return $this->getPost($post);
                },
                $posts
            ),
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit),
            'hasNextPage' => true,
            'hasPreviousPage' => false,
            'nextPage' => $total > $page * $limit ? $nextPage : null,
            'nextPageUrl' => $total > $page * $limit ? $this->urlGenerator->generate(
                'api_post_list',
                ['page' => $nextPage, 'limit' => $limit]
            ) : null,
            'previousPage' => $page === 1 ? null : $prevPage,
            'previousPageUrl' => $page === 1 ? null : $this->urlGenerator->generate(
                'api_post_list',
                ['page' => $prevPage, 'limit' => $limit]
            ),
            'firstPage' => 1,
            'lastPage' => ceil($total / $limit)
        ];
    }

    #[ArrayShape([
        'title' => "string",
        'content' => "string",
        'author' => "null[]",
        'image' => "string",
        'createdAt' => "string",
        'updatedAt' => "string",
        'links' => "array[]"
    ])] public function getPost(Post $post): array
    {
        return [
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'author' => [
                'email' => $post->getAuthor()?->getEmail(),
            ],
            'image' => $post->getImage(),
            'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $post->getUpdatedAt()->format('Y-m-d H:i:s'),
            'links' => [
                'self' => [
                    'href' => $this->urlGenerator->generate(
                        'api_post_get',
                        ['uuid' => $post->getId()]
                    )
                ]
            ]
        ];
    }
}
