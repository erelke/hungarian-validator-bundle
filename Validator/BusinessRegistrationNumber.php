<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BusinessRegistrationNumber extends Constraint
{
    public $message = "It is not a valid business registration number";

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
