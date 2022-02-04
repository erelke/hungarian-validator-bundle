<?php
/**
 * HuBankAccount.php
 * @created 2020.04.25. 9:55
 * @project PhpStorm hercules-api-2
 *
 * @copyright (C) 2020 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HuBankAccount extends Constraint
{
    public $message_format = 'Invalid HuBankAccount Format';
    public $message_check  = 'Invalid HuBankAccount Check';
    public $check_format = true;
    public $check_parts = true;
    public $single_part = false;

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
