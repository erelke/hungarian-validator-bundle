# Hungarian Validator Bundle

Symfony bundle a Magyarországon használt hivatalos adatok (úgy mint: személyi szám, adóazonosító jel, stb) validálására.

## Installálás

```bash
composer require erelke/hungarian-validator-bundle
```

## Használata / Példák

```php
<?php
namespace Acme\AcmeDemoBundle\Entity;

use Erelke\HungarianValidatorBundle\Validator as HungarianAssert;

class AcmeEntity {
  /**
   * @HungarianAssert\PersonalId(message="Hibás személyi szám")
   */
  protected $personal_id;

  // ...
}
```

Adóazonosító és a születési dátum kapcsolatának ellenőrzése:

```php
<?php
namespace Acme\AcmeDemoBundle\Entity;

use Erelke\HungarianValidatorBundle\Validator as HungarianAssert;

class AcmeUser {

  protected \DateTimeInterface $birthDate 
  
  /**
   * @HungarianAssert\TaxId(
   *    message="Hibás adózanosító!",
   *    birthdayMessage="Adóazonosító nem a megadott születési dátumhoz ({{ birthDate }}) tartozik!",     
   *    birthdayProperty="birthDate" 
   * )
   */
  protected ?string $taxId;

  // ...
}
```


## Elérhető validátorok

 * Irányítószám (ZipCode)
 * Adószám (VatNumber)
 * Adóazonosító jel (TaxId)
 * Személyi szám (PersonalId)
 * Személyazonosító igazolvány (kártya) szám (IdCardNumber)
 * Teljes név (FullName)
 * Cégjegyzékszám (BusinessRegistrationNumber)
 * Bankszámlaszám (HuBankAccount)
 * Taj szám (SocialSecurityNumber)
 * Vezetői engedély szám (DriverLicenceNumber)
 * Védettségi igazolvány szám (VaccinationCardNumber)
