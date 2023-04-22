<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountActionEnum;
use App\Enum\UserAccountStatusEnum;
use App\Enum\UserRolesEnum;
use App\Repository\UserAccountStatusHistoryRepository;
use Symfony\Component\Finder\Exception\AccessDeniedException;

readonly class UserService
{
    public function __construct(
        private UserAccountStatusHistoryRepository $userHistoryRepository,
    ) {
    }

    /**
     * @param User $operator - User from administration group
     * @param User $user     - User for whom an update is being called
     */
    public function updateUserHistory(
        UserAccountStatusHistory $userAccountStatusHistory,
        User $operator,
        User $user,
        UserAccountStatusEnum|UserAccountActionEnum $status
    ): void {
        if ([UserRolesEnum::User->value] === $operator->getRoles()) {
            throw new AccessDeniedException('User cannot update it\'s history');
        }

        $userAccountStatusHistory
            ->setOperator($operator)
            ->setForUser($user)
            ->setAction($status->value)
            ->setCreatedAt(new \DateTimeImmutable());

        $this->userHistoryRepository->save($userAccountStatusHistory, true);
    }
}
