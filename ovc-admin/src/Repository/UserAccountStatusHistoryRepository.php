<?php

namespace App\Repository;

use App\Entity\UserAccountStatusHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAccountStatusHistory>
 *
 * @method UserAccountStatusHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccountStatusHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccountStatusHistory[]    findAll()
 * @method UserAccountStatusHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAccountStatusHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccountStatusHistory::class);
    }

    public function save(UserAccountStatusHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserAccountStatusHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserAccountStatusHistory[] Returns an array of UserAccountStatusHistory objects
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

//    public function findOneBySomeField($value): ?UserAccountStatusHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
