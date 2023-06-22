<?php

namespace App\Validator\Command;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute]
class ServiceCommand extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The value "{{ value }}" is not valid.';

    public string $valueNotString = 'The value {{ value }} is not a string';

    public string $pregMatchFailed = 'The value {{ value }} does not follow the pattern [a-zA-Z_]{3,}';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }

    /**
     * @return string[]
     */
    public function getTargets(): array
    {
        return [self::PROPERTY_CONSTRAINT];
    }
}
