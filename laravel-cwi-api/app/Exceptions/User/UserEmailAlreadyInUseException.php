<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserEmailAlreadyInUseException extends Exception
{
    public function __construct(string $message = 'Email already in use.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

