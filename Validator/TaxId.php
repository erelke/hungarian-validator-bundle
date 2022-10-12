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
    public ?string $birthdayProperty;

    public function validatedBy()
    {
        return __CLASS__ . 'Validator';
    }

    public function __construct($options = null, array $groups = null, $payload = null, ?string $birthdayProperty = null )
    {
        parent::__construct($options, $groups, $payload);
        $this->birthdayProperty = $birthdayProperty;
    }
}
