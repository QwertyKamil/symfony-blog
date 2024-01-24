<?php

declare(strict_types=1);

namespace App\Post\Application\Command;

use App\Post\Application\Factory\PostFactory;
use App\Post\Domain\AuthorRepository;
use App\Post\Domain\Event\PostCreated;
use App\Post\Domain\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(
    method: 'handle'
)]
class CreateNewPostHandler
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly PostFactory $postFactory,
        private readonly MessageBusInterface $bus
    ) {
    }

    /**
     * @param CreateNewPost $command
     * @return void
     */
    public function handle(CreateNewPost $command): void
    {
        $postDto = $command->post;

        $author = $this->authorRepository->get($postDto->getAuthorUuid());
        $image = $postDto->getImage();
        //upload image

        $imageUrl = 'https://via.placeholder.com/150';

        $post = $this->postFactory->create(
            $postDto->getTitle(),
            $postDto->getContent(),
            $author,
            $imageUrl
        );

        $this->postRepository->save($post);

        $this->bus->dispatch(new PostCreated($author->getEmail(), $post->getTitle()));
    }
}
