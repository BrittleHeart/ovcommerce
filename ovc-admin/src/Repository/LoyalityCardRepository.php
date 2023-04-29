<?php

namespace App\Repository;

use App\Entity\LoyalityCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoyalityCard>
 *
 * @method LoyalityCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoyalityCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoyalityCard[]    findAll()
 * @method LoyalityCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoyalityCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyalityCard::class);
    }

    public function save(LoyalityCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LoyalityCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws \Exception
     */
    public function renewCard(LoyalityCard $card, \DateInterval $duration): void
    {
        $current = new \DateTimeImmutable();

        // For now, there's no sense for renewing a unexpired card
        if ($card->isExpired() && false === $card->isIsRenewable()) {
            return;
        }

        $card->setExpirationDate($current->add($duration));
        $card->setRenewedAt(new \DateTime());

        $this->save($card, true);
    }

//    /**
//     * @return LoyalityCard[] Returns an array of LoyalityCard objects
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

//    public function findOneBySomeField($value): ?LoyalityCard
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
