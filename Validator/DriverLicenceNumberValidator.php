<?php
/**
 * DriverLicenceNumberValidator.php
 * @created 2022. 05. 10. 14:29
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;
use Erelke\HungarianValidatorBundle\Validator\HungarianValidator;

class DriverLicenceNumberValidator extends HungarianValidator
{
	protected $pattern = '/
        ^
        [a-zA-Z]{2}
        [\- ]?
        \d{6}
        $
        /x';

	protected function check($value)
	{
		if( preg_match($this->pattern, $value) ) {
			return true;
		}

		return false;
	}
}