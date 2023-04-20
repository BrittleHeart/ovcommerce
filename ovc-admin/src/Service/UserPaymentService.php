<?php

namespace App\Service;

use App\Entity\UserPayment;
use App\Entity\UserPaymentHistory;
use App\Enum\UserPaymentStatusEnum;
use App\Repository\UserPaymentHistoryRepository;
use App\Repository\UserPaymentRepository;

readonly class UserPaymentService
{
    public function __construct(
        private UserPaymentRepository $paymentRepository,
        private UserPaymentHistoryRepository $paymentHistoryRepository,
    ) {
    }

    public function acceptPayment(UserPayment $userPayment): void
    {
        if (UserPaymentStatusEnum::Accepted->value === $userPayment->getStatus()) {
            return;
        }

        $userPayment->setStatus(UserPaymentStatusEnum::Accepted->value);
        $this->paymentRepository->save($userPayment, true);

        $this->attachNewUserPaymentHistory($userPayment);
    }

    public function rejectPayment(UserPayment $userPayment): void
    {
        if (UserPaymentStatusEnum::Rejected->value === $userPayment->getStatus()) {
            return;
        }

        $userPayment->setStatus(UserPaymentStatusEnum::Rejected->value);
        $this->paymentRepository->save($userPayment, true);

        $this->attachNewUserPaymentHistory($userPayment);
    }

    /**
     * Creates a new User Payment history record.
     */
    private function attachNewUserPaymentHistory(UserPayment $userPayment): void
    {
        $userPaymentHistory = new UserPaymentHistory();
        $userPaymentHistory->setForUser($userPayment->getForUser());
        $userPaymentHistory->setPaymentMethodStatus(
            $userPayment->getStatus() ?? UserPaymentStatusEnum::Rejected->value
        );

        $this->paymentHistoryRepository->save($userPaymentHistory, true);
    }
}
