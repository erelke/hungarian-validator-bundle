<?php
/**
 * HuBankAccountValidatorTest.php
 * @created 2020.04.25. 10:24
 * @project PhpStorm hercules-api-2
 *
 * @copyright (C) 2020 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Erelke\HungarianValidatorBundle\Validator\HuBankAccount;
use Erelke\HungarianValidatorBundle\Validator\HuBankAccountValidator;

class HuBankAccountValidatorTest extends ConstraintValidatorTestCase
{

	public function provideInValidFormat()
	{
		return [
			['0000000000000000'],
			['000000000000000'],
			['00000000000000000000000'],
			['00000000-0000000000000000'],
			['00000001-0000000000000001'],
		];
	}

	/**
	 * @param string $value
	 * @dataProvider provideInValidFormat
	 */
	public function testHuBankAccountInvalidFormat(string $value)
	{
		$constraint = new HuBankAccount();
		$constraint->check_parts = FALSE;

		$this->validator->validate($value, $constraint);

		$this->buildViolation($constraint->message_format)->setParameter('{{ value }}', $value)->assertRaised();
	}

	public function provideValidFormat()
	{
		return [
			['00000000-00000000'],
			['00000000-00000000-00000000'],
		];
	}

	/**
	 * @dataProvider provideValidFormat
	 * @param string $value
	 */
	public function testHuBankAccountValidFormat(string $value)
	{
		$constraint = new HuBankAccount();
		$constraint->check_parts = FALSE;
		$this->validator->validate($value, $constraint);
		$this->assertNoViolation();
	}

	public function provideInvalidCheck()
	{
		return [
			['10000000-00000000', '10000000'],
			['10000001-10000000', '10000000'],
			['10000001-10000000-10000000', '1000000010000000'],
			['10402283-10526653-68491004', '1052665368491004'],
			['11773054-01805946', '01805946'],
			['11773054-01805946-00000000', '0180594600000000'],
		];
	}

	/**
	 * @param string $value
	 * @param bool|false $second
	 * @dataProvider provideInvalidCheck
	 */
	public function testHuBankAccountInvalidCheck(string $value, string $part)
	{
		$constraint = new HuBankAccount();
		$constraint->check_format = FALSE;

		$this->validator->validate($value, $constraint);

		$this->buildViolation($constraint->message_check)
			->setParameter('{{ part }}', $part)
			->assertRaised();
	}

	public function provideValidCheck()
	{
		return [
			['10000001-10000001'],
			['10000001-00000000-00000000'],
			['10000001-10000000-00000001'],
			['10402283-50526653-68491004'],
			['11773054-00805946'],
			['10000001-00000000'],
		];
	}

	/**
	 * @param string $value
	 * @dataProvider provideValidCheck
	 */
    public function testHuBankAccountValidCheck(string $value)
    {
        $constraint = new HuBankAccount();
        $constraint->check_format = false;

        $this->validator->validate($value, $constraint);

	    $this->assertNoViolation();
    }

	public function provideInvalidPartial()
	{
		return [
			['10000000'],
			['11737082'],
			['1000000023455001'],
			['2012322000000001'],
		];
	}

	/**
	 * @param string $value
	 * @dataProvider provideInvalidPartial
	 */
	public function testHuBankAccountInvalidPartial(string $value)
    {
        $constraint = new HuBankAccount();
        $constraint->single_part = true;
        $constraint->check_format = false;

        $this->validator->validate($value, $constraint);

	    $this->buildViolation("Invalid HuBankAccount Check")
		        ->setParameter('{{ part }}', $value)
		    ->assertRaised();
    }

	public function provideValidPartial()
	{
		return [
			['10000001'],
			['11737083'],
			['1000000100010009'],
			['10000001 00010009'],
		];
	}

	/**
	 * @param string $value
	 * @dataProvider provideValidPartial
	 */
    public function testHuBankAccountValidPartial(string $value)
    {
        $constraint = new HuBankAccount();
        $constraint->single_part = true;
        $constraint->check_format = false;

        $this->validator->validate($value, $constraint);

	    $this->assertNoViolation();
    }

	protected function createValidator()
	{
		return new HuBankAccountValidator();
	}
}
