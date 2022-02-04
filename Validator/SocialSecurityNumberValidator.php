<?php

namespace Erelke\HungarianValidatorBundle\Validator;

/**
 * iranyitoszam ellenorzese
 */
class SocialSecurityNumberValidator extends HungarianValidator
{
    protected $pattern = '/
        ^
        [0-9]{3}
        [\ ]?               # szóköz
        [0-9]{3}
        [\ ]?               # szóköz
        [0-9]{3}
        $
        /x';


	protected function check($value)
	{
		if( preg_match($this->pattern, $value) === 0 ) {
			return false;
		}

		return $this->checkSum($value);
	}

	/**
	 * @param string $value
	 * @return boolean
	 *
	 * A kilenc számjegyből álló TAJ szám képzése a három azonosítószám-típus közül a legegyszerűbb.
	 * Az első nyolc számjegy egymás után sorban kerül kiosztásra, a kilencedik számjegy pedig egy ellenőrző szám,
	 * amelyet úgy képeznek, hogy a páratlan helyen álló számjegyeket hárommal,
	 * a páros helyen állókat pedig héttel szorozzák.
	 * Az így kapott számokat összeadják, elosztják 10-zel, és az osztás maradékát
	 * hozzáírják a sorban kiadott 8 számjegyhez kilencedik számként.
	 */
	protected function checkSum($value)
	{
		// felesleges elvalaszto karakterek eltavolitasa
		$value = preg_replace('/[^0-9]/', '', $value);

		$sum = 0;
		$l = strlen($value);
		for( $i = 0; $i < $l - 1; ++$i ) {
			$sum += (int)$value[$i] * ( ($i+1) % 2 ? 3 : 7);
		}

		return (($sum % 10) === (int)$value[$l - 1]);
	}

}
