<?php

namespace App\EventSubscriber;

use App\Entity\UserPayment;
use App\Entity\UserPaymentHistory;
use App\Enum\UserPaymentStatusEnum;
use App\Repository\UserPaymentHistoryRepository;
use App\Repository\UserPaymentRepository;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class UserPaymentSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPaymentHistoryRepository $paymentHistoryRepository,
        private UserPaymentRepository $paymentRepository,
    ) {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof UserPayment) {
            return;
        }

        $userPaymentHistory = new UserPaymentHistory();
        $userPaymentHistory->setForUser($entity->getForUser());
        $userPaymentHistory->setPaymentMethodStatus(UserPaymentStatusEnum::Submitted->value);
        $this->paymentHistoryRepository->save($userPaymentHistory, true);

        $userPaymentHistory->setForUser($entity->getForUser());
        $userPaymentHistory->setPaymentMethodStatus(UserPaymentStatusEnum::InValidation->value);
        $this->paymentHistoryRepository->save($userPaymentHistory, true);

        $entity->setStatus(UserPaymentStatusEnum::InValidation->value);
        $this->paymentRepository->save($entity, true);
    }

    /**
     * @return array<array-key, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
}
