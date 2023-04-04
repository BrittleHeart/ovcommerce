<?php

namespace App\Repository;

use App\Entity\UserProductOrderPointHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserProductOrderPointHistory>
 *
 * @method UserProductOrderPointHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProductOrderPointHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProductOrderPointHistory[]    findAll()
 * @method UserProductOrderPointHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProductOrderPointHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProductOrderPointHistory::class);
    }

    public function save(UserProductOrderPointHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserProductOrderPointHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserProductOrderPointHistory[] Returns an array of UserProductOrderPointHistory objects
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

//    public function findOneBySomeField($value): ?UserProductOrderPointHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
