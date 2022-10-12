<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TaxId extends Constraint
{
	const Message = "It is not a valid tax ID";
	public string $message = self::Message;
    public string $birthdayMessage = "This tax ID is not related to given date ({{ birthDate }}).";
    public ?string $birthdayProperty = null;

    public function validatedBy(): string
    {
        return __CLASS__ . 'Validator';
    }

    public function __construct($options = null, array $groups = null, $payload = null, ?string $birthdayProperty = null, ?string $birthdayMessage = null )
    {
        parent::__construct($options, $groups, $payload);
        $this->birthdayProperty = $birthdayProperty ?? $this->birthdayProperty;
        $this->birthdayMessage = $birthdayMessage ?? $this->birthdayMessage;
    }
}
