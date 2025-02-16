<?php

namespace App\Exceptions;


class InvalidBookingTimeException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Invalid booking time provided')
    {
        parent::__construct($message, 1004);
    }
}

