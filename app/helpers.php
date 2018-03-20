<?php

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

/**
 * @param int $length
 * @return string
 */
function generate_password(int $length = 8): string
{

    $generator = new ComputerPasswordGenerator();

    $generator
        ->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, true)
        ->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, true)
        ->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, true)
        ->setLength($length);

    return $generator->generatePassword();
}