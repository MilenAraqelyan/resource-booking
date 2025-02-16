<?php

namespace App\Exceptions;

class BookingOverlapException extends BaseBookingException
{
    protected $statusCode = 409;

    public function __construct(string $message = 'Booking overlaps with existing booking')
    {
        parent::__construct($message, 1005);
    }
}
