<?php

namespace App\Exceptions;

use Exception;

class ValidationFailedException extends Exception
{
    protected $errors;

    public function __construct($errors, $message = 'Validation failed', $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
