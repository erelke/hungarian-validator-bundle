# Hungarian Validator Bundle

## Installálás

composer.json fájlba:
```json
{
  "repositories": [
      {
          "type": "vcs",
          "url": "https://github.com/erelke/hungarian-validator-bundle.git"
      },
  ],
  "require": {
      "erelke/hungarian-validator-bundle": "^1.0.0",
  }
}
```

```bash
php composer.phar update spe/hungarian-validator-bundle
```

## Használata

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

## Elérhető validátorok

 * Irányítószám (ZipCode)
 * Adószám (VatNumber)
 * Adóazonosító jel (TaxId)
 * Személyi szám (PersonalId)
 * Személyazonosító igazolvány (kártya) szám (IdCardNumber)
 * Teljes név (FullName)
 * Cégjegyzékszám (BusinessRegistrationNumber)
 * Bankszámlaszám (HuBankAccount)
