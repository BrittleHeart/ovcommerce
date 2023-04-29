<?php

namespace App\Validator;

use App\Entity\LoyalityPoint as LoyaltyPointEntity;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LoyaltyPointValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof LoyaltyPoint) {
            return;
        }

        $valueType = gettype($value);
        assert($value instanceof LoyaltyPointEntity, "The value argument is $valueType");

        $loyaltyCard = $value->getCard();
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
    }
}
