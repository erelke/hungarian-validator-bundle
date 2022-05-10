<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TaxId extends Constraint
{
	const Message = "It is not a valid tax ID";
	public $message = self::Message;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }
}
