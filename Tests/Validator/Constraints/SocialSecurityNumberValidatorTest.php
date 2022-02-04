<?php

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use Erelke\HungarianValidatorBundle\Validator\SocialSecurityNumber;
use Erelke\HungarianValidatorBundle\Validator\SocialSecurityNumberValidator;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class SocialSecurityNumberValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator()
    {
        return new SocialSecurityNumberValidator();
    }

    /**
     * @dataProvider provideInvalidSocialSecurityNumbers
     */
    public function testInvalidSocialSecurityNumbers($value)
    {
        $this->validator->validate($value, new SocialSecurityNumber());
        $this->buildViolation("It is not a valid Social Security Number")
            ->assertRaised();
    }

    public function provideInvalidSocialSecurityNumbers()
    {
        return [
            ['111 111 111'],
            ['00 000 000'],
            ['0000000000'],
        ];
    }

    /**
     * @dataProvider provideValidSocialSecurityNumbers
     */
    public function testValidSocialSecurityNumbers($value)
    {
        $this->validator->validate($value, new SocialSecurityNumber());
        $this->assertNoViolation();
    }

    public function provideValidSocialSecurityNumbers()
    {
        return [
            ['111 000 003'],
            ['111000003'],
            ['113998139'],
            ['113 998 139'],
        ];
    }
}
