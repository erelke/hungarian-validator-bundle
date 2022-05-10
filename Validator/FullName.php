<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullName extends Constraint
{
	const Message = "Please enter your full name";
	public $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
