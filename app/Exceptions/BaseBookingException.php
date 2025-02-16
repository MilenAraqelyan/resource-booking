<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class BaseBookingException extends Exception
{
    protected $statusCode = 500;

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $this->getMessage(),
                'code' => $this->getCode(),
                'type' => class_basename($this)
            ]
        ], $this->statusCode);
    }
}
