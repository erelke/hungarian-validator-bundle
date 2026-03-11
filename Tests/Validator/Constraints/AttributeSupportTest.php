<?php
/**
 * AttributeSupportTest.php
 * @created 2026. 03. 11. 14:15
 * @project hungarian-validator-bundle
 *
 * @copyright (C) 2016 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Erelke\HungarianValidatorBundle\Tests\Validator\Constraints;

use Attribute;
use Erelke\HungarianValidatorBundle\Validator\BusinessRegistrationNumber;
use Erelke\HungarianValidatorBundle\Validator\DriverLicenceNumber;
use Erelke\HungarianValidatorBundle\Validator\FullName;
use Erelke\HungarianValidatorBundle\Validator\HuBankAccount;
use Erelke\HungarianValidatorBundle\Validator\IdCardNumber;
use Erelke\HungarianValidatorBundle\Validator\PersonalId;
use Erelke\HungarianValidatorBundle\Validator\SocialSecurityNumber;
use Erelke\HungarianValidatorBundle\Validator\TaxId;
use Erelke\HungarianValidatorBundle\Validator\VaccinationCardNumber;
use Erelke\HungarianValidatorBundle\Validator\Valid;
use Erelke\HungarianValidatorBundle\Validator\VatNumber;
use Erelke\HungarianValidatorBundle\Validator\ZipCode;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class AttributeSupportTest extends TestCase
{
    /**
     * @dataProvider provideConstraintClasses
     */
    public function testConstraintCanBeUsedAsAttribute(string $constraintClass): void
    {
        $reflection = new ReflectionClass($constraintClass);
        $attributes = $reflection->getAttributes(Attribute::class);

        $this->assertNotEmpty(
            $attributes,
            sprintf('A(z) "%s" osztály nem használható PHP attributumként.', $constraintClass)
        );

        $instance = $attributes[0]->newInstance();

        $this->assertSame(
            Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE,
            $instance->flags
        );
    }

    public function provideConstraintClasses(): array
    {
        return [
            [BusinessRegistrationNumber::class],
            [DriverLicenceNumber::class],
            [FullName::class],
            [HuBankAccount::class],
            [IdCardNumber::class],
            [PersonalId::class],
            [SocialSecurityNumber::class],
            [TaxId::class],
            [VaccinationCardNumber::class],
            [Valid::class],
            [VatNumber::class],
            [ZipCode::class],
        ];
    }
}