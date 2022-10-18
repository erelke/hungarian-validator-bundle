<?php

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use DateTime;
use DateTimeInterface;
use Erelke\HungarianValidatorBundle\Validator\TaxId;
use Erelke\HungarianValidatorBundle\Validator\TaxIdValidator;

use stdClass;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TaxIdValidatorTest extends ConstraintValidatorTestCase
{

    public function createValidator(): TaxIdValidator
    {
        return new TaxIdValidator();
    }

    /**
     * @dataProvider provideInvalidTaxIds
     */
    public function testInvalidTaxIds($value)
    {
        $this->validator->validate($value, new TaxId());
        $this->buildViolation("It is not a valid tax ID")
            ->assertRaised();
    }

    public function provideInvalidTaxIds(): array
    {
        return [
            ['832825870'],
            ['8 32825 870 9'],
            ['8 12825 870 8'],
            ['1 32825 870 8'],
        ];
    }

    /**
     * @dataProvider provideValidTaxIds
     */
    public function testValidTaxIds($value)
    {
        $this->validator->validate($value, new TaxId());
        $this->assertNoViolation();
    }

    public function provideValidTaxIds(): array
    {
        return [
            ['8 32825 870 6'],
            ['8-32825-870-6'],
            ['8328258706'],
        ];
    }

    /**
     * @dataProvider provideInvalidBirthDayTaxIds
     */
    public function testInvalidBirthDayTaxIds($value, DateTimeInterface $birthday)
    {
        $path = 'birthday';
        $any = new stdClass();
        $any->$path = $birthday;
//        $any->taxId = $value;
//        $this->setValue($value);
//        $this->setPropertyPath($path);
        $this->setObject($any);
//

        $constraint = new TaxId();
        $constraint->birthdayProperty = $path;

        $this->validator->validate($value, $constraint);
        $this->buildViolation( $constraint->birthdayMessage)
            ->setInvalidValue($value)
            ->setParameter('{{ birthDate }}',$birthday->format("Y. m. d.") )
            ->assertRaised();
    }

    public function provideInvalidBirthDayTaxIds(): array
    {
        return [
            ['8328258706', new DateTime('1956-11-10')],
            ['8599998706', new DateTime('2031-04-11')],
	        ['8460820084', new DateTime('1993-03-02')],
        ];
    }

    /**
     * @dataProvider provideValidBirthDayTaxIds
     */
    public function testValidBirthDayTaxIds($value, DateTimeInterface $birthday)
    {
        $path = 'birthday';
        $any = new stdClass();
        $any->$path = $birthday;
        $any->taxId = $value;
        $this->setValue($value);
        $this->setPropertyPath($path);
        $this->setObject($any);

        $constraint = new TaxId();
        $constraint->birthdayProperty = $path;

        $this->validator->validate($value, $constraint);
        $this->assertNoViolation();
    }

    public function provideValidBirthDayTaxIds(): array
    {
        return [
            ['8 32825 870 6', new DateTime('1956-11-15')],
            ['8-32825-870-6', new DateTime('1956-11-15')],
            ['8328258706', new DateTime('1956-11-15')],
            ['8328258706', new DateTime('1956-11-15')],
            ['8599998706', new DateTime('2031-04-10')],
	        ['8460820084', new DateTime('1993-03-03')],

        ];
    }
}
