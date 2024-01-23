<?php

declare(strict_types=1);

namespace App\Post\Domain;

class Author
{
    public function __construct(
        private readonly AuthorId $id,
        private readonly string $name,
        private readonly string $email,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): AuthorId
    {
        return $this->id;
    }
}
