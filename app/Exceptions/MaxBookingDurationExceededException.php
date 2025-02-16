<?php

namespace App\Exceptions;


class MaxBookingDurationExceededException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Maximum booking duration exceeded')
    {
        parent::__construct($message, 1007);
    }
}
