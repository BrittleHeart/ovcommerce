<?php

namespace App\Repository;

use App\Entity\UserCardRankingHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCardRankingHistory>
 *
 * @method UserCardRankingHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCardRankingHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCardRankingHistory[]    findAll()
 * @method UserCardRankingHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCardRankingHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCardRankingHistory::class);
    }

    public function save(UserCardRankingHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserCardRankingHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserCardRankingHistory[] Returns an array of UserCardRankingHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserCardRankingHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
