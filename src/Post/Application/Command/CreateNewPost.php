<?php

declare(strict_types=1);

namespace App\Post\Application\Command;

use App\Post\Application\Dto\PostDTO;

class CreateNewPost
{
    public function __construct(
        public readonly PostDTO $post
    ) {
    }
}
