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

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class VaccinationCardNumber extends Constraint
{
	const Message = "It is not a valid vaccination card number";
	public $message = self::Message;
}