<?php

namespace App\Validator\Command;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ServiceCommandValidator extends ConstraintValidator
{
    /**
     * @throws UnexpectedTypeException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var App\Validator\Command\ServiceCommand $constraint */
        if (!$constraint instanceof ServiceCommand) {
            throw new UnexpectedTypeException($constraint, ServiceCommand::class);
        }

        if (!is_string($value)) {
            return;
        }

        if ('' === $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ message }}', $value)
                ->addViolation();
        }

        if (!preg_match('/^[a-zA-Z_]{3,}?$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ pregMatchFailed }}', $value)
                ->addViolation();
        }
    }
}
