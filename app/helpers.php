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

/**
 * @param int $number
 * @return string
 */
function format_number(int $number): string
{
    return number_format($number, 0, '.', ' ');
}

/**
 * @param \Carbon\Carbon $date
 * @return string
 */
function format_date(\Carbon\Carbon $date = null): ?string
{
    if (!$date) {
        return null;
    }

    return $date->format('d.m.Y H:i:s');
}