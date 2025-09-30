<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = 'User not found.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
