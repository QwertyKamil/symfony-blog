<?php

declare(strict_types=1);

namespace App\Post\Application\Command;

use App\Post\Application\Factory\PostFactory;
use App\Post\Domain\AuthorRepository;
use App\Post\Domain\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(
    method: 'handle'
)]
class CreateNewPostHandler
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly PostFactory $postFactory,
        private readonly array $allowedTags = ['<ul>', '<li>', '<ol>', '<p>', '<strong>']
    ) {
    }

    /**
     * @param CreateNewPost $command
     * @return void
     */
    public function handle(CreateNewPost $command): void
    {
        $postDto = $command->getPost();

        $author = $this->authorRepository->get($postDto->getAuthorUuid());
        $image = $postDto->getImage();
        //upload image

        $imageUrl = 'https://via.placeholder.com/150';

        $post = $this->postFactory->create(
            strip_tags($postDto->getTitle(), []),
            strip_tags($postDto->getContent(), $this->allowedTags),
            $author,
            $imageUrl
        );

        $this->postRepository->save($post);
    }
}
