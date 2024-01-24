<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Controller;

use App\Post\Application\Command\CreateNewPost;
use App\Post\Application\Dto\PostDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/v1', name: 'api_')]
class RestController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
    }

    /**
     * @param PostDTO $post
     * @return JsonResponse
     */
    #[Route('/posts', name: 'posts-create', methods: ['PUT'])]
    #[OA\RequestBody(request: PostDTO::class, description: 'Post object', required: true)]
    public function createPost(
        #[MapRequestPayload(validationGroups: ['create'])] PostDTO $post
    ): JsonResponse {
        $this->bus->dispatch(new CreateNewPost($post));

//        $this->createNewPost->setPost($post);
//        $this->bus->dispatch($this->createNewPost);

        return $this->json([
            'message' => 'Post created successfully'
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @param int $page
     * @param int $limit
     * @return JsonResponse
     */
    #[Route('/posts', name: 'posts-list', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $page = 1,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $limit = 10,
    ): JsonResponse {
        $posts = [
            [
                'nasme' => 'post1',
                'content' => 'content1',
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => '/api/v1/posts/1',
                        'type' => 'GET'
                    ],
                    [
                        'rel' => 'self',
                        'href' => '/api/v1/posts/1',
                        'type' => 'PUT'
                    ],
                    [
                        'rel' => 'self',
                        'href' => '/api/v1/posts/1',
                        'type' => 'DELETE'
                    ]
                ]
            ],
            [
                'name' => 'post1',
                'content' => 'content1',
                'links' => [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/2',
                    'type' => 'GET'
                ],
                [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/2',
                    'type' => 'PUT'
                ],
                [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/2',
                    'type' => 'DELETE'
                ]
            ],
            [
                'name' => 'post1',
                'content' => 'content1',
                'links' => [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/3',
                    'type' => 'GET'
                ],
                [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/3',
                    'type' => 'PUT'
                ],
                [
                    'rel' => 'self',
                    'href' => '/api/v1/posts/3',
                    'type' => 'DELETE'
                ]
            ],
        ];
        $nextPage = $page + 1;
        $prevPage = $page - 1;
        $total = 20;

        return $this->json([
            'items' => $posts,
            'total' => 20,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit),
            'hasNextPage' => true,
            'hasPreviousPage' => false,
            'nextPage' => $nextPage,
            'nextPageUrl' => "/api/v1/posts?page=$nextPage&limit=$limit",
            'previousPage' => $page === 1 ? null : $prevPage,
            'previousPageUrl' => $page === 1 ? null : "/api/v1/posts?page=$prevPage&limit=$limit",
            'firstPage' => 1,
            'lastPage' => 2
        ]);
    }
}
