<?php

declare(strict_types=1);

namespace App\Auth\Domain\Repository;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserRepository
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;
}
