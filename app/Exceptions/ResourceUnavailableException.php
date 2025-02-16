<?php

namespace App\Exceptions;


class ResourceUnavailableException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Resource is currently unavailable')
    {
        parent::__construct($message, 1006);
    }
}
