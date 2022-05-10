<?php
/**
 * Valid.php
 * @created 2022. 05. 10. 14:02
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;
use Symfony\Component\Validator\Constraint;

class Valid extends Constraint
{
	public string $message = "It is a not valid number!";
	public ?int $type = self::Other;

	public $message_format = 'Invalid HuBankAccount Format';
	public $message_check  = 'Invalid HuBankAccount Check';
	public $check_format = true;
	public $check_parts = true;
	public $single_part = false;

	const IdCardNumber = 1;
	const AddressCardNumber = 2;
	const DriverLicenceNumber = 3;
	const PassportNumber = 4;
	const TaxId = 5;
	const SocialSecurityNumber = 6;
	const StudentCardNumber = 7;
	const VaccinationCardNumber = 8;
	const PersonalId = 9;
	const BusinessRegistrationNumber = 11;
	const VatNumber = 12;
	const BankAccount = 21;
	const ZipCode = 31;
	const FullName = 32;
	const Other = 99;

	public function __construct($options = NULL, ?int $type = self::Other, $groups = NULL, $payload = NULL) {

		parent::__construct($options, $groups, $payload);

		$this->type = $type ?? $this->type;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage(string $message): void
	{
		$this->message = $message;
	}
}