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
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Erelke\HungarianValidatorBundle\Validator\Valid;
use Erelke\HungarianValidatorBundle\Validator\ValidValidator;

class ValidValidatorTest extends ConstraintValidatorTestCase
{

	protected function createValidator()
	{
		return new ValidValidator();
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

	public function testValidBankAccount()
	{
		$value='10000001-10000000-00000001';
		$this->validator->validate($value, new Valid(null, Valid::BankAccount));
		$this->assertNoViolation();
	}
}