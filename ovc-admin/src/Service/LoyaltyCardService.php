<?php

namespace App\Service;

use App\Entity\LoyalityCard;
use App\Entity\UserCardRankingHistory;
use App\Enum\UserCardRankingHistoryActionEnum;
use App\Repository\UserCardRankingHistoryRepository;

class LoyaltyCardService
{
    public function __construct(
        private readonly UserCardRankingHistoryRepository $cardRankingRepository,
    ) {
    }

    /**
     * Creates the UserUserCardRankingHistory record with Action.
     */
    public function createCardHistoryWithAction(
        LoyalityCard $card,
        UserCardRankingHistoryActionEnum $cardHistoryEnum,
    ): void {
        $cardHistory = new UserCardRankingHistory();
        $cardHistory->setForUser($card->getHolder());
        $cardHistory->setLoyalityCard($card);
        $cardHistory->setAction($cardHistoryEnum->value);
        $this->cardRankingRepository->save($cardHistory, true);
    }
}
