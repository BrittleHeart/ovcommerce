<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Entity\UserPayment;
use App\Entity\UserPaymentHistory;
use App\Enum\UserPaymentStatusEnum;
use App\Enum\UserPaymentTypeEnum;
use App\Repository\UserPaymentHistoryRepository;
use App\Repository\UserPaymentRepository;
use App\Service\UserPaymentService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPaymentServiceTest extends KernelTestCase
{
    private MockObject $paymentRepository;
    private MockObject $paymentHistoryRepository;
    private UserPaymentService $userPaymentService;

    private UserPayment $userPayment;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        self::bootKernel();

        $this->paymentRepository = $this->createMock(UserPaymentRepository::class);
        $this->paymentHistoryRepository = $this->createMock(UserPaymentHistoryRepository::class);

        $this->userPaymentService = new UserPaymentService(
            $this->paymentRepository,
            $this->paymentHistoryRepository
        );

        $user = new User();
        $user->setEmail('admin@example.com');

        $this->userPayment = new UserPayment();
        $this->userPayment->setForUser($user);
        $this->userPayment->setStatus(UserPaymentStatusEnum::InValidation->value);
        $this->userPayment->setPaymentType(UserPaymentTypeEnum::Cash->value);
        $this->userPayment->setCardExpirationDay(new \DateTime());
    }

    #[Test]
    public function shouldAcceptUserPayment(): void
    {
        $this->paymentRepository->expects($this->once())
            ->method('save')
            ->with($this->userPayment, true);

        $this->paymentHistoryRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(UserPaymentHistory::class), true);

        $this->userPaymentService->acceptPayment($this->userPayment);
        $this->assertSame(UserPaymentStatusEnum::Accepted->value, $this->userPayment->getStatus());
    }

    #[Test]
    public function shouldRejectUserPayment(): void
    {
        $this->paymentRepository->expects($this->once())
            ->method('save')
            ->with($this->userPayment, true);

        $this->paymentHistoryRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(UserPaymentHistory::class), true);

        $this->userPaymentService->rejectPayment($this->userPayment);
        $this->assertSame(UserPaymentStatusEnum::Rejected->value, $this->userPayment->getStatus());
    }
}
