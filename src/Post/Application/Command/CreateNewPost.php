<?php

declare(strict_types=1);

namespace App\Post\Application\Command;

use App\Post\Application\Dto\PostDTO;

class CreateNewPost
{
    public function __construct(
        private PostDTO $post
    ) {
    }

    public function getPost(): PostDTO
    {
        return $this->post;
    }

    public function setPost(PostDTO $post): void
    {
        $this->post = $post;
    }
}
