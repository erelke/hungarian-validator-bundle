<?php
/**
 * VaccinationCardNumberValidatorTest.php
 * @created 2022. 05. 10. 15:35
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Tests\Validator\Constraints;

use Erelke\HungarianValidatorBundle\Validator\VaccinationCardNumber;
use Erelke\HungarianValidatorBundle\Validator\VaccinationCardNumberValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class VaccinationCardNumberValidatorTest extends ConstraintValidatorTestCase
{

	protected function createValidator()
	{
		return new VaccinationCardNumberValidator();
	}

	/**
	 * @dataProvider provideInvalidVaccinationCardNumbers
	 */
	public function testInvalidVaccinationCardNumbers($value)
	{
		$this->validator->validate($value, new VaccinationCardNumber());
		$this->buildViolation(VaccinationCardNumber::Message)
			->assertRaised();
	}

	public function provideInvalidVaccinationCardNumbers()
	{
		return [
			['A 12345678'],
			['A-12345678'],
			['A123456789'],
			['A1234567'],
			['12345678'],
			['123456789'],

			['A12345670'],
			['A12345671'],
			['A12345673'],
			['A12345674'],
			['A12345675'],
			['A12345676'],
			['A12345677'],
			['A12345678'],
			['A12345679'],
		];
	}

	/**
	 * @dataProvider provideValidVaccinationCardNumbers
	 */
	public function testValidVaccinationCardNumbers($value)
	{
		$this->validator->validate($value, new VaccinationCardNumber());
		$this->assertNoViolation();
	}

	public function provideValidVaccinationCardNumbers()
	{
		return [
			['V15604516'],
			['A12345672'],
		];
	}
}