<?php

namespace App\Repository;

use App\Entity\UserAddressHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAddressHistory>
 *
 * @method UserAddressHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAddressHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAddressHistory[]    findAll()
 * @method UserAddressHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAddressHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddressHistory::class);
    }

    public function save(UserAddressHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserAddressHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserAddressHistory[] Returns an array of UserAddressHistory objects
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

//    public function findOneBySomeField($value): ?UserAddressHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
