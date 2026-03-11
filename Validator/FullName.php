<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class FullName extends Constraint
{
	const Message = "Please enter your full name";
	public $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
