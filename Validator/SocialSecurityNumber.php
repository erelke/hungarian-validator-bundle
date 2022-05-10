<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SocialSecurityNumber extends Constraint
{
	const Message = "It is not a valid Social Security Number";
	public $message = self::Message;

	public function validatedBy()
	{
		return __CLASS__ . 'Validator';
	}

}
