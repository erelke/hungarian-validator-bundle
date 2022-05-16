<?php
/**
 * HuBankAccount.php
 * @created 2020.04.25. 9:55
 * @project PhpStorm hercules-api-2
 *
 * @copyright (C) 2020 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HuBankAccount extends Constraint
{
    public string $message_format = 'Invalid HuBankAccount Format';
    public string $message_check  = 'Invalid HuBankAccount Check';
    public bool $check_format = true;
    public bool $check_parts = true;
    public bool $single_part = false;

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }

	public function __construct($options = NULL, ?bool $check_format = null,?bool $check_parts = null,?bool $single_part = null, $groups = NULL, $payload = NULL)
	{

		parent::__construct($options, $groups, $payload);

		$this->check_format = $check_format ?? $this->check_format;
		$this->check_parts = $check_parts ?? $this->check_parts;
		$this->single_part = $single_part ?? $this->single_part;
	}
}
