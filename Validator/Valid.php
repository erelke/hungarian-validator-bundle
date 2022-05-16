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
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * @Annotation
 */
class Valid extends Constraint
{
	public string $message = "It is a not valid number!";
	public ?int $type = null;
	public ?string $propertyPath = null;

	public string $message_format = 'Invalid HuBankAccount Format';
	public string $message_check  = 'Invalid HuBankAccount Check';
	public bool $check_format = true;
	public bool $check_parts = true;
	public bool $single_part = false;

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

	public function __construct($options = NULL, ?int $type = null, ?string $propertyPath = null, $groups = NULL, $payload = NULL) {

		parent::__construct($options, $groups, $payload);

		$this->type = $type ?? $this->type;
		$this->propertyPath = $propertyPath ?? $this->propertyPath;

		if (null === $this->type && null === $this->propertyPath) {
			//$this->type = self::Other;
			throw new ConstraintDefinitionException(sprintf('The "%s" constraint requires either the "type" or "propertyPath" option to be set.', static::class));
		}

		if (null !== $this->type && null !== $this->propertyPath) {
			throw new ConstraintDefinitionException(sprintf('The "%s" constraint requires only one of the "type" or "propertyPath" options to be set, not both.', static::class));
		}

		if (null !== $this->propertyPath && !class_exists(PropertyAccess::class)) {
			throw new LogicException(sprintf('The "%s" constraint requires the Symfony PropertyAccess component to use the "propertyPath" option.', static::class));
		}
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

	/**
	 * {@inheritdoc}
	 */
	public function getDefaultOption()
	{
		return 'type';
	}
}