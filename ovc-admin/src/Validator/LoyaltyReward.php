<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class LoyaltyReward extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The "{{ property }}" is required, when "Reward Type" is "Discount".';

    public string $tooLowPoints = 'The card "{{ card }}" has insufficient points. Required {{ points }} points.';

    public string $cardInactive = 'The card "{{ card }}" is inactive.';

    public string $cardExpired = 'The card "{{ card }}" has already expired.';

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
