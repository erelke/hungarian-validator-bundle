<?php

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use Erelke\HungarianValidatorBundle\Validator\ZipCode;
use Erelke\HungarianValidatorBundle\Validator\ZipCodeValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ZipCodeValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new ZipCodeValidator();
    }

    /**
     * @dataProvider provideInvalidZipCodes
     */
    public function testInvalidZipCodes($value)
    {
        $this->validator->validate($value, new ZipCode());
        $this->buildViolation("It is not a valid ZIP code")
            ->assertRaised();
    }

    public function provideInvalidZipCodes()
    {
        return [
            ['12345'],
            ['0123'],
            ['1243'],
        ];
    }

    /**
     * @dataProvider provideValidZipCodes
     */
    public function testValidZipCodes($value)
    {
        $this->validator->validate($value, new ZipCode());
        $this->assertNoViolation();
    }

    public function provideValidZipCodes()
    {
        return [
            ['1234'],
            ['1106'],
        ];
    }
}
