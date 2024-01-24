<?php

declare(strict_types=1);

namespace App\Post\Domain\Event;

class PostCreated
{
    public function __construct(
        public readonly string $email,
        public readonly string $title
    ) {
    }
}
