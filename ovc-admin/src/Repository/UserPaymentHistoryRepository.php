<?php

namespace App\Repository;

use App\Entity\UserPaymentHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPaymentHistory>
 *
 * @method UserPaymentHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPaymentHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPaymentHistory[]    findAll()
 * @method UserPaymentHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPaymentHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPaymentHistory::class);
    }

    public function save(UserPaymentHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserPaymentHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserPaymentHistory[] Returns an array of UserPaymentHistory objects
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

//    public function findOneBySomeField($value): ?UserPaymentHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
