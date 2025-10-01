<?php

namespace App\Exceptions\External;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ExternalServiceException extends Exception
{
    public function __construct(string $message = 'External service request failed.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
