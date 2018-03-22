<?php

namespace App\Services\Youtube;

class ResponseException extends \Exception
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
}