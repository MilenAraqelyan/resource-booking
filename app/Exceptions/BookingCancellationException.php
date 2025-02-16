<?php

namespace App\Exceptions;


class BookingCancellationException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Unable to cancel the booking')
    {
        parent::__construct($message, 1003);
    }
}
