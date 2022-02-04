<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PersonalId extends Constraint
{
    public $message = "It is not a valid personal ID";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
