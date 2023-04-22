<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountStatusEnum;
use App\Enum\UserRolesEnum;
use App\Repository\UserAccountStatusHistoryRepository;
use App\Service\UserService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase
{
    private UserService $userService;
    private MockObject $userStatusHistoryRepository;

    private User $testUser;
    private User $operator;
    private UserAccountStatusHistory $userAccountStatusHistory;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        self::bootKernel();

        $this->userStatusHistoryRepository = $this->createMock(UserAccountStatusHistoryRepository::class);
        $this->userService = new UserService(
            $this->userStatusHistoryRepository,
        );

        $this->testUser = new User();
        $this->operator = new User();
        $this->operator
            ->setRoles([UserRolesEnum::Admin->name]);
        $this->testUser
            ->setRoles([UserRolesEnum::User->name]);

        $this->userAccountStatusHistory = new UserAccountStatusHistory();
        $this->userAccountStatusHistory
            ->setAction(UserAccountStatusEnum::Open->value)
            ->setForUser($this->testUser)
            ->setOperator($this->operator)
            ->setCreatedAt(new \DateTimeImmutable());
    }

    #[Test]
    public function updateUserHistoryMethodShouldUpdateHistory(): void
    {
        $this->userStatusHistoryRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(UserAccountStatusHistory::class), true);

        $action = UserAccountStatusEnum::Blocked;
        $this->userService->updateUserHistory(
            $this->userAccountStatusHistory,
            $this->operator,
            $this->testUser,
            $action
        );

        $this->assertSame($action->value, $this->userAccountStatusHistory->getAction());
    }
}
