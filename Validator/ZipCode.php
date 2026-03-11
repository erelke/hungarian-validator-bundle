<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ZipCode extends Constraint
{
	const Message = "It is not a valid ZIP code";
	public string $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}

