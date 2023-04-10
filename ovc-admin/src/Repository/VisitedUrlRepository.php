<?php

namespace App\Repository;

use App\Entity\VisitedUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VisitedUrl>
 *
 * @method VisitedUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitedUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitedUrl[]    findAll()
 * @method VisitedUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitedUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitedUrl::class);
    }

    public function save(VisitedUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VisitedUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VisitedUrl[] Returns an array of VisitedUrl objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VisitedUrl
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
