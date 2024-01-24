<?php

declare(strict_types=1);

namespace App\Post\Infrastructure\Persistence\Doctrine;

use App\Post\Domain\Entity\Post;
use App\Post\Domain\PostRepository as PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int       count(array $criteria)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $post): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($post);
        $entityManager->flush();
    }

    public function get(Uuid $postUuid): Post
    {
        return $this->find($postUuid->toBinary());
    }

    public function delete(Post $post): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($post);
        $entityManager->flush();
    }

    public function deleteById(Uuid $postUuid): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->createQuery(
            sprintf('DELETE FROM %s p WHERE p.uuid = :uuid', Post::class)
        )->setParameter(
            'uuid',
            $postUuid->toBinary()
        )->execute();
    }
}
