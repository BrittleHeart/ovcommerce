<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountStatusEnum;
use App\Repository\UserAccountStatusHistoryRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class UpdateUserAccountHistoryEvent implements EventSubscriberInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserAccountStatusHistoryRepository $userAccountStatusHistoryRepository,
    ) {
    }

    public function updateUserAccountStatusHistoryEvent(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $operator = $this->userRepository->findOneBy(['email' => 'admin@example.com']);
        $user = $this->userRepository->find($entity->getId());
        if (null === $operator || null === $user) {
            return;
        }

        $user->setUpdatedAt(new \DateTime());
        $this->userRepository->save($user, true);

        $userAccountStatusHistoryEntity = new UserAccountStatusHistory();
        $userAccountStatusHistoryEntity
            ->setOperator($operator)
            ->setForUser($user)
            ->setAction($entity->getStatus() ?? UserAccountStatusEnum::Open->value)
            ->setCreatedAt(new \DateTimeImmutable());

        $this->userAccountStatusHistoryRepository->save($userAccountStatusHistoryEntity);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => 'updateUserAccountStatusHistoryEvent',
        ];
    }
}
