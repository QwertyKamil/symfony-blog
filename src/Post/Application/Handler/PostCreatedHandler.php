<?php

declare(strict_types=1);

namespace App\Post\Application\Handler;

use App\Post\Domain\Event\PostCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(
    method: 'handle'
)]
class PostCreatedHandler
{
    public function handle(PostCreated $postCreated): void
    {
        //send email
    }
}
