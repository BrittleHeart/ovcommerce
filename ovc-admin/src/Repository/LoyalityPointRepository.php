<?php

namespace App\Repository;

use App\Entity\LoyalityPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyalityPoint>
 *
 * @method LoyalityPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoyalityPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoyalityPoint[]    findAll()
 * @method LoyalityPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoyalityPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyalityPoint::class);
    }

    public function save(LoyalityPoint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LoyalityPoint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LoyalityPoint[] Returns an array of LoyalityPoint objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LoyalityPoint
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
