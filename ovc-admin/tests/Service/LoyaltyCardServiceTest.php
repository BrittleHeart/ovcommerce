<?php

namespace App\Tests\Service;

use App\Entity\LoyalityCard;
use App\Entity\UserCardRankingHistory;
use App\Enum\UserCardRankingHistoryActionEnum;
use App\Repository\UserCardRankingHistoryRepository;
use App\Service\LoyaltyCardService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoyaltyCardServiceTest extends KernelTestCase
{
    private MockObject $cardHistoryRepository;
    private LoyaltyCardService $loyaltyCardService;
    private LoyalityCard $loyaltyCard;
    private UserCardRankingHistory $cardRankingHistory;

    public function setUp(): void
    {
        self::bootKernel();

        $this->cardHistoryRepository = $this->createMock(UserCardRankingHistoryRepository::class);
        $this->loyaltyCardService = new LoyaltyCardService($this->cardHistoryRepository);

        $this->loyaltyCard = new LoyalityCard();
        $this->loyaltyCard->setIsRenewable(true);
        $this->loyaltyCard->setIsActive(true);

        $this->cardRankingHistory = new UserCardRankingHistory();
        $this->cardRankingHistory->setAction(UserCardRankingHistoryActionEnum::NewCard->value);
    }

    #[Test]
    public function shouldCreateAHistoryRecordWithNewCardActionPassed(): void
    {
        $this->cardHistoryRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(UserCardRankingHistory::class), true);

        $this->loyaltyCardService->createCardHistoryWithAction(
            $this->loyaltyCard,
            UserCardRankingHistoryActionEnum::NewCard
        );

        /* @var UserCardRankingHistory|null $historyRanking */
        $historyRanking = $this->cardHistoryRepository->findOneBy(['action' => UserCardRankingHistoryActionEnum::NewCard->value]);
        if (null === $historyRanking) {
            return;
        }

        $this->assertSame((int) $historyRanking->getAction(), UserCardRankingHistoryActionEnum::NewCard->value);
    }
}
