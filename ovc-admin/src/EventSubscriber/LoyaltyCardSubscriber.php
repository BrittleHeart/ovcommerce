<?php

namespace App\EventSubscriber;

use App\Entity\LoyalityCard;
use App\Enum\LoyalityCardTypeEnum;
use App\Enum\UserCardRankingHistoryActionEnum;
use App\Repository\LoyalityCardRepository;
use App\Service\LoyaltyCardService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class LoyaltyCardSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoyaltyCardService $loyaltyCardService,
        private LoyalityCardRepository $loyalityCardRepository,
    ) {
    }

    public function onBeforeCardPersistedEvent(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof LoyalityCard) {
            return;
        }

        $this->loyaltyCardService->createCardHistoryWithAction($entity, UserCardRankingHistoryActionEnum::NewCard);
    }

    /**
     * @throws \Exception
     */
    public function onBeforeCardUpdatedEvent(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof LoyalityCard) {
            return;
        }

        if ($entity->isExpired()) {
            $this->loyaltyCardService->createCardHistoryWithAction($entity, UserCardRankingHistoryActionEnum::CardRankingExpired);
        }

        if (null !== $entity->getHolder()) {
            $this->loyaltyCardService->createCardHistoryWithAction($entity, UserCardRankingHistoryActionEnum::UserAssigned);
        }

        // card type changed from lets say gold to silver
        if ($entity->getPreviousCardType() !== $entity->getCardType()) {
            $entity->setPreviousCardType($entity->getCardType() ?? LoyalityCardTypeEnum::Silver->value);
            $this->loyalityCardRepository->save($entity, true);
            $this->loyaltyCardService->createCardHistoryWithAction($entity, UserCardRankingHistoryActionEnum::CardRankingChanged);
        }

        if (false === $entity->isIsActive()) {
            $this->loyaltyCardService->createCardHistoryWithAction($entity, UserCardRankingHistoryActionEnum::DeactivatedCard);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforeCardPersistedEvent',
            BeforeEntityUpdatedEvent::class => 'onBeforeCardUpdatedEvent',
        ];
    }
}
