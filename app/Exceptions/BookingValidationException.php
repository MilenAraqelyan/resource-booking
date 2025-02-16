<?php

namespace App\Exceptions;


class BookingValidationException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Invalid booking data provided')
    {
        parent::__construct($message, 1002);
    }
}
