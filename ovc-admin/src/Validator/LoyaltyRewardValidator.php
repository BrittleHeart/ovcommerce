<?php

namespace App\Validator;

use App\Entity\LoyalityReward as LoyaltyRewardEntity;
use App\Enum\RewardTypeEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LoyaltyRewardValidator extends ConstraintValidator
{
    /**
     * @throws \Exception
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof LoyaltyReward) {
            return;
        }

        $valueType = gettype($value);
        assert($value instanceof LoyaltyRewardEntity, "The value argument is $valueType");

        if (RewardTypeEnum::Discount->value === $value->getRewardType() && null === $value->getRewardValue()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ property }}', 'reward_value')
                ->addViolation();
        }

        $loyaltyCard = $value->getLoyalityCard();
        if (null === $loyaltyCard) {
            return;
        }

        if ($loyaltyCard->isExpired()) {
            $this->context->buildViolation($constraint->cardExpired)
                ->setParameter('{{ card }}', $loyaltyCard->getCardNumber() ?? '')
                ->addViolation();

            return;
        }

        if (!$loyaltyCard->isIsActive()) {
            $this->context->buildViolation($constraint->cardInactive)
                ->setParameter('{{ card }}', $loyaltyCard->getCardNumber() ?? '')
                ->addViolation();

            return;
        }

        if ($value->getPointsRequired() > $loyaltyCard->countPoints()) {
            $this->context->buildViolation($constraint->tooLowPoints)
                ->setParameter('{{ card }}', $loyaltyCard->getCardNumber() ?? '')
                ->setParameter('{{ points }}', (string) $value->getPointsRequired())
                ->addViolation();
        }
    }
}
