<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\External\FetchExternalMessageUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExternalController extends Controller
{
    public function __construct(private readonly FetchExternalMessageUseCase $fetchExternalMessage)
    {
    }

    public function fetchExternalMessage(): JsonResponse
    {
        $payload = $this->fetchExternalMessage->handle();

        return response()->json($payload, Response::HTTP_OK);
    }
}

