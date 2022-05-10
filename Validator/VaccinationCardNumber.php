<?php
/**
 * VaccinationCardNumber.php
 * @created 2022. 05. 10. 14:53
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;
use Symfony\Component\Validator\Constraint;

class VaccinationCardNumber extends Constraint
{
	const Message = "It is not a valid vaccination card number";
	public $message = self::Message;
}