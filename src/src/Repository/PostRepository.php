<?php

namespace App\Repository;

use App\Crate\RestRequest;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param RestRequest $restRequest
     *
     * @return Collection
     * @throws \Exception
     */
    public function getListByRestRequest(RestRequest $restRequest): Collection
    {
        $qb = $this->createQueryBuilder('POST');
        $qb->leftJoin('POST.tags', 'TAG');

        if ($restRequest->orderDirection && $restRequest->orderField) {
            $qb->addOrderBy($restRequest->orderField, $restRequest->orderDirection);
        }

        if ($restRequest->page !== null && $restRequest->limit !== null) {
            $qb->setFirstResult($restRequest->page * $restRequest->limit);
            $qb->setMaxResults($restRequest->limit);
        }

        $paginator = new Paginator($qb);
        $result = new ArrayCollection($paginator->getIterator()->getArrayCopy());

        // Partially hydrate all required tags so we avoid 1+N problem while keeping usable performance.
        // https://ocramius.github.io/blog/doctrine-orm-optimization-hydration/
        $partialQb = $this->createQueryBuilder('POST');
        $partialQb->select('PARTIAL POST.{id}');
        $partialQb->addSelect('TAG');
        $partialQb->leftJoin('POST.tags', 'TAG');
        $partialQb->where('POST in (:posts)');
        $partialQb->setParameter('posts', $result);
        $partialQb->getQuery()->getResult();

        return $result;
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
