<?php

declare(strict_types=1);

namespace App\Post\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Stringable;

abstract class AbstractId implements Stringable
{
    /**
     * @param string $id
     */
    private function __construct(protected string $id)
    {
        $this->ensureIsValidUuid($id);
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public static function next(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function equalTo(AbstractId $id): bool
    {
        return $this->getId() === $id->getId() &&
            get_class($this) === get_class($id);
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $id));
        }
    }
}
