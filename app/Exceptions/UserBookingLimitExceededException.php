<?php

namespace App\Exceptions;


class UserBookingLimitExceededException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'User has exceeded their booking limit')
    {
        parent::__construct($message, 1008);
    }
}
