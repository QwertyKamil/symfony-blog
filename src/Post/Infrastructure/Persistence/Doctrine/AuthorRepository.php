<?php

declare(strict_types=1);

namespace App\Post\Infrastructure\Persistence\Doctrine;

use App\Post\Domain\AuthorRepository as AuthorRepositoryInterface;
use App\Post\Domain\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int       count(array $criteria)
 */
class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function get(Uuid $authorUuid): Author
    {
        return new Author($authorUuid, 'test', 'test@email.com');//$this->findOneBy(['id' => $authorUuid->toBinary()]);
    }
}
