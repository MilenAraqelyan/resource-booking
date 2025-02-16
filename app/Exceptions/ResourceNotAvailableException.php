<?php

namespace App\Exceptions;


class ResourceNotAvailableException extends BaseBookingException
{
    protected $statusCode = 422;

    public function __construct(string $message = 'Resource is not available for the requested time period')
    {
        parent::__construct($message, 1001);
    }
}
