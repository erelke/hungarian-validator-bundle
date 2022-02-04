<?php
/**
 * HuBankAccountValidator.php
 * @created 2020.04.25. 9:57
 * @project PhpStorm hercules-api-2
 *
 * @copyright (C) 2020 EchoBase Services
 *            LMS e-tan Kft.
 * @author Erőss Elemér
 *         eross.elemer@echobase.hu
 */

namespace Erelke\HungarianValidatorBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HuBankAccountValidator extends ConstraintValidator
{

    /**
     * @param mixed $value
     * @param Constraint|HuBankAccount $constraint
     * @return bool
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) return true;

        $pattern = '/^[0-9]{8}[-][0-9]{8}([-][0-9]{8})?$/';
        $sCheckTags = '9731';

        if ($constraint->check_format && preg_match($pattern, $value) === 0) {
            $this->context->buildViolation($constraint->message_format)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        if ($constraint->check_parts) {
            //kötőjelek és más szemét kipucolása. Ha formátum ellenőrzés van, akkor csak kötőjel lehet benne
            $value = str_replace(["-", ' ', "/", "~", ".", ',', '_'],"", $value );

            if ($constraint->single_part) {
                $part1 = $value;
            } else {
                $part1 = substr($value,0,8);
                $part2 = substr($value, 8);
            }

            $check = 0;
            for ($i = 0; $i < strlen($part1); $i++) {
                $check += $part1[$i] * $sCheckTags[$i % 4];
            }

            if ($check % 10) {
                $this->context->buildViolation($constraint->message_check)
                    ->setParameter('{{ part }}', $part1)
                    ->addViolation();
            }

            if (!$constraint->single_part) {
                $check = 0;

                for ($i = 0; $i < strlen($part2); $i++) { //8 vagy 16 hosszú
                    $check += $part2[$i] * $sCheckTags[$i % 4];
                }

                if ($check % 10) {
                    $this->context->buildViolation($constraint->message_check)
                        ->setParameter('{{ part }}', $part2)
                        ->addViolation();
                }
            }
        }
    }
}
