<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BusinessRegistrationNumber extends Constraint
{
	const Message = "It is not a valid business registration number";
    public $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
