<?php

declare(strict_types=1);

namespace App\Post\Infrastructure\Persistence\Doctrine;

use App\Post\Domain\Post;
use App\Post\Domain\PostId;
use App\Post\Domain\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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

    public function get(PostId $postId): Post
    {
        return $this->findOneBy(
            ['uuid' => $postId]
        );
    }

    public function delete(Post $post): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($post);
        $entityManager->flush();
    }

    public function deleteById(PostId $postId): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->createQuery(
            'DELETE FROM App\Post\Domain\Post p WHERE p.uuid = :uuid'
        )->setParameter(
            'uuid',
            $postId
        )->execute();
    }
}
