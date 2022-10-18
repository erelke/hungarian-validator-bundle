<?php

namespace Erelke\HungarianValidatorBundle\Validator;

use DateTime;
use DateTimeInterface;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * adoazonosito jel ellenorzese
 *
 * Az adoazonosito szamot a torveny szerint az alabbiak szerint kell kepezni:
 *  - az 1. szamjegy konstans 8-as szam, mely az adoalany maganszemely voltara
 *    utal
 *  - a 2–6. szamjegyek a szemely szuletesi idopontja es az 1867. januar 1.
 *    kozott eltelt napok szama (vagyis 1900. januar 1-jetol a szuletesi
 *    idopontig eltelt napok szama + 12 051)
 *  - a 7–9. szamjegyek az azonos napon szuletettek megkulonboztetesere szolgalo
 *    veletlenszeruen kepzett sorszam,
 *  - a 10. szamjegy az 1–9. szamjegyek felhasznalasaval matematikai modszerekkel
 *    kepzett ellenorzo szam.
 *  - Az adoazonosito jel tizedik szamjegyet ugy kell kepezni, hogy az elso
 *    szamjegyek mindegyiket szorozni kell azzal a sorszammal, ahanyadik helyet
 *    foglalja el az azonositon belul. (Elso szamjegy szorozva eggyel, masodik
 *    szamjegy szorozva kettovel es igy tovabb.) Az igy kapott szorzatok
 *    osszeget el kell osztani 11-gyel, es az osztas maradeka a tizedik
 *    szamjeggyel lesz egyenlo. A 7–9. szamjegyek szerinti szuletesi sorszam nem
 *    adhato ki, ha a 11-gyel valo osztas maradeka egyenlo tizzel.
 *
 * http://hu.wikipedia.org/wiki/Ad%C3%B3azonos%C3%ADt%C3%B3_jel
 */
class TaxIdValidator extends HungarianValidator
{

    private ?PropertyAccessorInterface $propertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    // Csak a 1921-10-05 es 2031-04-10 kozotti datumokat fogadja el! (6-os már 2058-08-26 lenne)
    protected $pattern = '/
        ^
        8
        [\- ]?
        [2-5][0-9]{4} # 20000-59999, ezert, csak a fent elmitett ket datum kozott
                      # szuletetteket fogadja el
        [\- ]?
        [0-9]{3}
        [\- ]?
        [0-9]         # ellenorzo szam
        $
        /x';


    /**
     * @param string $value
     * @param Constraint|TaxId $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if( !$this->haveToValidate($value) ) {
            return;
        }

        if( !$this->isValidType($value) ) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if ($path = $constraint->birthdayProperty) {
            if (null !== $object = $this->context->getObject()) {
                try {
                    $birthday = $this->getPropertyAccessor()->getValue($object, $path);
                } catch (NoSuchPropertyException $e) {
                    throw new ConstraintDefinitionException(sprintf('Invalid property path "%s" provided to "%s" constraint: ', $path, get_debug_type($constraint)).$e->getMessage(), 0, $e);
                }
				if ($birthday !== null) {
					if (!$birthday instanceof DateTimeInterface) {
						throw new ConstraintDefinitionException(sprintf('Value for property path "%s" provided to "%s" constraint is not instance of DateTimeInterface!', $path, get_debug_type($constraint)));
					}
					$isValid = $this->checkDate($value, $birthday);
					if (!$isValid) {
						$this->context->buildViolation($constraint->birthdayMessage)->setParameter('{{ birthDate }}', $birthday->format('Y. m. d.'))->setInvalidValue($value)->addViolation();
					}
				}
            }
        }

        $isValid = $this->check($value);

        if( !$isValid ) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    protected function checkDate($value, DateTimeInterface $birthday): bool
    {
        $ref = new DateTime("1867-01-01");
        $days = $birthday->diff($ref)->days + 1;
        $cleanedValue = str_replace([' ', '-'], '', $value);
        $part = substr($cleanedValue, 1, 5);
        return (int)$part === $days;
    }

    protected function check($value): bool
    {
        if( preg_match($this->pattern, $value) === 0 ) {
            return false;
        }

        return $this->checkSum($value);
    }

    private function getPropertyAccessor(): PropertyAccessorInterface
    {
        if (null === $this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}
