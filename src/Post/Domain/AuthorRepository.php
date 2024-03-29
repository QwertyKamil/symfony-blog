<?php

declare(strict_types=1);

namespace App\Post\Domain;

use App\Post\Domain\Entity\Author;
use Symfony\Component\Uid\Uuid;

interface AuthorRepository
{
    public function get(Uuid $authorUuid): Author;
}
