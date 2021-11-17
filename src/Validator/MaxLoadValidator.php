<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxLoadValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\MaxLoad */

        if (null === $value || '' === $value) {
            return;
        }

        $maxAllowed    = $this->context->getRoot()->getWeight();
        $val = 0;

        foreach ($value as $medication) {
            $val += $medication->getWeight();
        }

        if ($val > $maxAllowed) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $val)
            ->setParameter('{{ allowed }}', $maxAllowed)
            ->addViolation();
        }
    }
}
