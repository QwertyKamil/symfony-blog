<?php

declare(strict_types=1);

namespace App\Post\UI\Http\Controller;

use App\Post\Domain\PostRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'api_')]
class RestController extends AbstractController
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {
    }

    #[Route('/posts', name: 'posts', methods: ['GET'])]
    public function index()
    {
        $posts = $this->postRepository->findBy([], ['createdAt' => 'DESC'], 10, 0);

        return $this->json($posts);
    }
}
