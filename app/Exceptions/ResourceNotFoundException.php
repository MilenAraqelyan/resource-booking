<?php

namespace App\Exceptions;


class ResourceNotFoundException extends BaseBookingException
{
    protected $statusCode = 404;

    public function __construct(string $message = 'Resource not found')
    {
        parent::__construct($message, 404);
    }
}
