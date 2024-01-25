<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Controller;

use App\Post\Application\Command\CreateNewPost;
use App\Post\Application\Dto\PostDTO;
use App\Post\Application\Query\PaginationPost;
use App\Post\Domain\PostRepository;
use App\Post\UI\ViewModel\PostList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Uid\Uuid;

#[Route('/api/v1', name: 'api_')]
class PostRestController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly PostRepository $repository,
    ) {
    }

    /**
     * @param PostDTO $post
     * @return JsonResponse
     */
    #[Route('/posts', name: 'post_create', methods: ['PUT'])]
    #[OA\RequestBody(request: PostDTO::class, description: 'Post object', required: true)]
    public function createPost(
        #[MapRequestPayload(validationGroups: ['create'])] PostDTO $post
    ): JsonResponse {
        $this->bus->dispatch(new CreateNewPost($post));

        return $this->json([
            'message' => 'Post created successfully'
        ], Response::HTTP_ACCEPTED);
    }

    #[Route('/posts/{uuid}', name: 'post_get', methods: ['GET'])]
    public function show(
        string $uuid,
        PostList $postList
    ): JsonResponse {
        //TODO - add query inside repository
        $post = $this->repository->get(Uuid::fromString($uuid));

        return $this->json($postList->getPost($post));
    }

    /**
     * @param int $page
     * @param int $limit
     * @param PaginationPost $paginationPost
     * @param PostList $postList
     * @return JsonResponse
     */
    #[Route('/posts', name: 'post_list', methods: ['GET'])]
    public function index(
        PaginationPost $paginationPost,
        PostList $postList,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $page = 1,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $limit = 10
    ): JsonResponse {
        return $this->json(
            $postList->getPostsPaginated(
                $paginationPost->getPosts($page, $limit),
                $page,
                $limit
            )
        );
    }


}
