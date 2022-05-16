<?php
/**
 * DriverLicenceNumber.php
 * @created 2022. 05. 10. 14:28
 * @project erelke-hungarian-validator-bundle
 *
 * @copyright (C) 2022 Korona Szoftver Kft.
 * @author Erőss Elemér
 *         eross.elemer@korona.info.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DriverLicenceNumber extends Constraint
{
	const Message = "It is not a valid driver licence number";
	public $message = self::Message;
}