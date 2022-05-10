<?php
/**
 * VaccinationCardNumberValidator.php
 * @created 2022. 05. 10. 14:54
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;

/**
 * Hungarian Covid vaccination card number
 * (védettségi igazolvány szám)
 */
class VaccinationCardNumberValidator extends HungarianValidator
{
	protected $pattern = '/
        ^
        [a-zA-Z]
        \d{8}
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
	 * @param $value
	 * @return bool
	 *
	 * Az első 7 számjegyből a páratlan helyen álló számjegyeket hárommal, a páros helyen állókat pedig héttel szorozzák.
	 * Az így kapott számokat összeadják, elosztják 10-zel, és az osztás maradéka az utolsó (nyolcadik) számjegy
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