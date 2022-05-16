<?php
/**
 * ValidValidatorTest.php
 * @created 2022. 05. 10. 15:55
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2016 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Tests\Validator\Constraints;
use Erelke\HungarianValidatorBundle\Validator\BusinessRegistrationNumber;
use Erelke\HungarianValidatorBundle\Validator\DriverLicenceNumber;
use Erelke\HungarianValidatorBundle\Validator\FullName;
use Erelke\HungarianValidatorBundle\Validator\HuBankAccount;
use Erelke\HungarianValidatorBundle\Validator\IdCardNumber;
use Erelke\HungarianValidatorBundle\Validator\PersonalId;
use Erelke\HungarianValidatorBundle\Validator\SocialSecurityNumber;
use Erelke\HungarianValidatorBundle\Validator\TaxId;
use Erelke\HungarianValidatorBundle\Validator\VaccinationCardNumber;
use Erelke\HungarianValidatorBundle\Validator\VatNumber;
use Erelke\HungarianValidatorBundle\Validator\ZipCode;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Erelke\HungarianValidatorBundle\Validator\Valid;
use Erelke\HungarianValidatorBundle\Validator\ValidValidator;

class ValidValidatorTest extends ConstraintValidatorTestCase
{

	protected function createValidator()
	{
		return new ValidValidator(new PropertyAccessor());
	}

	/**
	 * @dataProvider provideInvalidData
	 */
	public function testInvalidData($value, $type, $message)
	{
		$this->validator->validate($value, new Valid(null, $type));
		$this->buildViolation($message)
			->assertRaised();
	}

	public function provideInvalidData()
	{
		return [
			['AA1234567', Valid::DriverLicenceNumber, DriverLicenceNumber::Message],
			['01 090 562739', Valid::BusinessRegistrationNumber, BusinessRegistrationNumber::Message],
			['Péterke ', Valid::FullName, FullName::Message],
			['123456A', Valid::IdCardNumber, IdCardNumber::Message],
			['3-110714-122', Valid::PersonalId, PersonalId::Message],
			['111 111 111', Valid::SocialSecurityNumber, SocialSecurityNumber::Message],
			['8 32825 870 9', Valid::TaxId, TaxId::Message],
			['A123456789', Valid::VaccinationCardNumber, VaccinationCardNumber::Message],
			['1013691-4-44', Valid::VatNumber, VatNumber::Message],
			['12345', Valid::ZipCode, ZipCode::Message],
		];
	}

	/**
	 * @dataProvider provideValidData
	 */
	public function testValidData($value, $type)
	{
		$this->validator->validate($value, new Valid(null, $type));
		$this->assertNoViolation();
	}

	public function provideValidData()
	{
		return [
			['AB123456', Valid::DriverLicenceNumber],
			['01 09 562739', Valid::BusinessRegistrationNumber],
			['Dr. prof. Kiss Pippin', Valid::FullName],
			['123456-AA', Valid::IdCardNumber],
			['3-110714-1231', Valid::PersonalId],
			['111000003', Valid::SocialSecurityNumber],
			['8-32825-870-6', Valid::TaxId],
			['V15604516', Valid::VaccinationCardNumber],
			['10136915-4-44', Valid::VatNumber],
			['1106', Valid::ZipCode],
		];
	}

	/**
	 * @param $check_parts
	 * @param $check_format
	 * @param $single_part
	 * @return Valid
	 */
	private function setConstraint($check_parts, $check_format, $single_part): Valid
	{
		$constraint = new Valid(null, Valid::BankAccount);
		$constraint->check_format = $check_format;
		$constraint->check_parts = $check_parts;
		$constraint->single_part = $single_part;

		return $constraint;
	}

	public function provideInvalidBankAccounts()
	{
		return [
			['0000000000000000', false, true, false, ''],
			['000000000000000', false, true, false, ''],
			['00000000000000000000000', false, true, false, ''],
			['00000000-0000000000000000', false, true, false, ''],
			['00000001-0000000000000001', false, true, false, ''],
			['10000000-00000000', true, false, false, '10000000'],
			['10000001-10000000', true, false, false, '10000000'],
			['10000001-10000000-10000000', true, false, false, '1000000010000000'],
			['10402283-10526653-68491004', true, false, false, '1052665368491004'],
			['11773054-01805946', true, false, false, '01805946'],
			['11773054-01805946-00000000', true, false, false, '0180594600000000'],
			['10000000', true, false, true, ''],
			['11737082', true, false, true, ''],
			['1000000023455001', true, false, true, ''],
			['2012322000000001', true, false, true, ''],
		];
	}

	/**
	 * @dataProvider provideInvalidBankAccounts
	 */
	public function testInvalidBankAccounts($value, $check_parts, $check_format, $single_part, $part)
	{
		$constraint =  $this->setConstraint($check_parts, $check_format, $single_part);
		$this->validator->validate($value, $constraint);
		if (!empty($part)) {
			$this->buildViolation($constraint->message_check)->setParameter('{{ part }}', $part)->assertRaised();
		} elseif ($single_part) {
			$this->buildViolation("Invalid HuBankAccount Check")
				->setParameter('{{ part }}', $value)
				->assertRaised();
		} else {
			$this->buildViolation($constraint->message_format)->setParameter('{{ value }}', $value)->assertRaised();
		}
	}

	public function provideValidBankAccounts()
	{
		return [
			['00000000-00000000', false, true, false],
			['00000000-00000000-00000000', false, true, false],
			['10000001-10000001', true, false, false],
			['10000001-00000000-00000000', true, false, false],
			['10000001-10000000-00000001', true, false, false],
			['10402283-50526653-68491004', true, false, false],
			['11773054-00805946', true, false, false],
			['10000001-00000000', true, false, false],
			['10000001', true, false, true],
			['11737083', true, false, true],
			['1000000100010009', true, false, true],
			['10000001 00010009', true, false, true],
		];
	}

	/**
	 * @dataProvider provideValidBankAccounts
	 */
	public function testValidBankAccounts($value, $check_parts, $check_format, $single_part)
	{
		$this->validator->validate($value, $this->setConstraint($check_parts, $check_format, $single_part));
		$this->assertNoViolation();
	}

	private function setTestObject($type): string
	{
		$path = 'CardType';

		$object = new \stdClass();
		$object->$path = $type;
		$this->setPropertyPath($path);
		$this->setValue($type);
		$this->setObject($object);

		return $path;
	}

	/**
	 * @dataProvider provideInvalidData
	 */
	public function testInvalidDataWithPropertyPath($value, $type, $message)
	{
		$path = $this->setTestObject($type);
		$this->validator->validate($value, new Valid(null, null, $path));
		$this->buildViolation($message)->setInvalidValue($type)->atPath($path)
			->assertRaised();
	}


	/**
	 * @dataProvider provideValidData
	 */
	public function testValidDataWithPropertyPath($value, $type) {
		$path = $this->setTestObject($type);
		$this->validator->validate($value, new Valid(null, null, $path));
		$this->assertNoViolation();
	}
}