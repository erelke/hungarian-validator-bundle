<?php
/**
 * DriverLicenceNumberValidatorTest.php
 * @created 2022. 05. 10. 15:09
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Tests\Validator\Constraints;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Erelke\HungarianValidatorBundle\Validator\DriverLicenceNumber;
use Erelke\HungarianValidatorBundle\Validator\DriverLicenceNumberValidator;

class DriverLicenceNumberValidatorTest extends ConstraintValidatorTestCase
{
	public function createValidator()
	{
		return new DriverLicenceNumberValidator();
	}

	/**
	 * @dataProvider provideInvalidDriverLicenceNumbers
	 */
	public function testInvalidDriverLicenceNumbers($value)
	{
		$this->validator->validate($value, new DriverLicenceNumber());
		$this->buildViolation(DriverLicenceNumber::Message)
			->assertRaised();
	}

	public function provideInvalidDriverLicenceNumbers()
	{
		return [
			['AA1234567'],
			['A123456'],
			['A1234567'],
			['123456BB'],
			['12345678'],
		];
	}

	/**
	 * @dataProvider provideValidDriverLicenceNumbers
	 */
	public function testValidDriverLicenceNumbers($value)
	{
		$this->validator->validate($value, new DriverLicenceNumber());
		$this->assertNoViolation();
	}

	public function provideValidDriverLicenceNumbers()
	{
		return [
			['AB123456'],
			['AB-123456'],
			['DF 325476'],
		];
	}
}