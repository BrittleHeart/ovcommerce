<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class LoyaltyPoint extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $cardInactive = 'Card {{ card }} is inactive.';

    public string $cardExpired = 'Card {{ card }} has already expired';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }

    /**
     * @return string[]
     */
    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT];
    }
}
