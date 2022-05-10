<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IdCardNumber extends Constraint
{
    const Message = "It is not a valid personal ID card number";
	public $message = self::Message;

	public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
