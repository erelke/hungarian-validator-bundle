<?php

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use DateTime;
use DateTimeInterface;
use Erelke\HungarianValidatorBundle\Validator\TaxId;
use Erelke\HungarianValidatorBundle\Validator\TaxIdValidator;

use stdClass;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TaxIdValidatorTest extends ConstraintValidatorTestCase
{

    public function createValidator()
    {
        return new TaxIdValidator();
    }

    /**
     * @dataProvider provideInvalidTaxIds
     */
    public function testInvalidTaxIds($value, ?DateTimeInterface $birthday)
    {
        if ($birthday instanceof DateTimeInterface) {
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
            $this->buildViolation("It is not a valid tax ID")->setInvalidValue($value)->atPath($path)
                ->assertRaised();
        } else {
            $this->validator->validate($value, new TaxId());
            $this->buildViolation("It is not a valid tax ID")
                ->assertRaised();
        }

    }

    public function provideInvalidTaxIds()
    {
        return [
            ['832825870', null],
            ['8 32825 870 9', null],
            ['8 12825 870 8', null],
            ['1 32825 870 8', null],
            ['8328258706', new DateTime('1956-11-10')],
            ['8328258707', new DateTime('1956-11-15')],
            ['8600008706', new DateTime('2031-04-10')],

        ];
    }

    /**
     * @dataProvider provideValidTaxIds
     */
    public function testValidTaxIds($value, ?DateTimeInterface $birthday)
    {
        if ($birthday instanceof DateTimeInterface) {
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
        } else {
            $this->validator->validate($value, new TaxId());
        }
            $this->assertNoViolation();
    }

    public function provideValidTaxIds()
    {
        return [
            ['8 32825 870 6', null],
            ['8-32825-870-6', null],
            ['8328258706', null],
            ['8 32825 870 6', new DateTime('1956-11-15')],
            ['8-32825-870-6', new DateTime('1956-11-15')],
            ['8328258706', new DateTime('1956-11-15')],
            ['8328258706', new DateTime('1956-11-15')],
            ['8599998706', new DateTime('2031-04-10')],
            ['8600008706', new DateTime('2031-04-11')],
        ];
    }
}
