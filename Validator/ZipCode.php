<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ZipCode extends Constraint
{
	const Message = "It is not a valid ZIP code";
	public string $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}

