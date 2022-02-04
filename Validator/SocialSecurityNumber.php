<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SocialSecurityNumber extends Constraint
{
	public $message = "It is not a valid Social Security Number";

	public function validatedBy()
	{
		return __CLASS__ . 'Validator';
	}

}
