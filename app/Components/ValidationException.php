<?php

namespace App\Components;


class ValidationException extends Exception
{
    public function __construct($data, $message = 'Invalid input')
    {
        parent::__construct($message, ErrorCode::INVALID_INPUT, $data);
    }
}