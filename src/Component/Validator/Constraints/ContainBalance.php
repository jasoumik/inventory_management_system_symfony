<?php


namespace App\Component\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class ContainBalance extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}