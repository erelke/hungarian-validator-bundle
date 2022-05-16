<?php
/**
 * ValidValidator.php
 * @created 2022. 05. 10. 14:12
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidValidator extends ConstraintValidator
{
	private PropertyAccessorInterface $propertyAccessor;

	public function __construct(PropertyAccessorInterface $propertyAccessor = null)
	{
		$this->propertyAccessor = $propertyAccessor;
	}

	/**
	 * @inheritDoc
	 */
	public function validate($value, Constraint $constraint)
	{
		if (!$constraint instanceof Valid) {
			throw new UnexpectedTypeException($constraint, Valid::class);
		}

		if (null === $value) {
			return;
		}

		$validator = $this->getValidator($constraint);

		if ($validator instanceof ConstraintValidator) {
			$validator->initialize($this->context);
			$validator->validate($value, $constraint);
		}
	}

	private function getValidator(Valid &$constraint): ?ConstraintValidator
	{
		if ($path = $constraint->propertyPath) {
			if (null === $object = $this->context->getObject()) {
				return null;
			}

			try {
				$type = $this->getPropertyAccessor()->getValue($object, $path);
			} catch (NoSuchPropertyException $e) {
				throw new ConstraintDefinitionException(sprintf('Invalid property path "%s" provided to "%s" constraint: ', $path, get_debug_type($constraint)).$e->getMessage(), 0, $e);
			}
		} else {
			$type = $constraint->type;
		}

		switch ($type) {
			case Valid::IdCardNumber:
				$constraint->setMessage(IdCardNumber::Message);
				return new IdCardNumberValidator();
			case Valid::BusinessRegistrationNumber:
				$constraint->setMessage(BusinessRegistrationNumber::Message);
				return new BusinessRegistrationNumberValidator();
			case Valid::FullName:
				$constraint->setMessage(FullName::Message);
				return new FullNameValidator();
			case Valid::BankAccount:
				return new HuBankAccountValidator();
			case Valid::PersonalId:
				$constraint->setMessage(PersonalId::Message);
				return new PersonalIdValidator();
			case Valid::SocialSecurityNumber:
				$constraint->setMessage(SocialSecurityNumber::Message);
				return new SocialSecurityNumberValidator();
			case Valid::TaxId:
				$constraint->setMessage(TaxId::Message);
				return new TaxIdValidator();
			case Valid::VatNumber:
				$constraint->setMessage(VatNumber::Message);
				return new VatNumberValidator();
			case Valid::ZipCode:
				$constraint->setMessage(ZipCode::Message);
				return new ZipCodeValidator();
			case Valid::DriverLicenceNumber:
				$constraint->setMessage(DriverLicenceNumber::Message);
				return new DriverLicenceNumberValidator();
			case Valid::VaccinationCardNumber:
				$constraint->setMessage(VaccinationCardNumber::Message);
				return new VaccinationCardNumberValidator();
			default:
				return null;
		}

	}

	private function getPropertyAccessor(): PropertyAccessorInterface
	{
		if (null === $this->propertyAccessor) {
			$this->propertyAccessor = PropertyAccess::createPropertyAccessor();
		}

		return $this->propertyAccessor;
	}
}