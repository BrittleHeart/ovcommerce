<?php

namespace App\Repository;

use App\Entity\LoyalityReward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyalityReward>
 *
 * @method LoyalityReward|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoyalityReward|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoyalityReward[]    findAll()
 * @method LoyalityReward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoyalityRewardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyalityReward::class);
    }

    public function save(LoyalityReward $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LoyalityReward $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LoyalityReward[] Returns an array of LoyalityReward objects
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

//    public function findOneBySomeField($value): ?LoyalityReward
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
