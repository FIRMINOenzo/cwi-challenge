<?php

namespace App\UseCases\External;

use App\Contracts\Services\ExternalServiceClientInterface;
use App\Contracts\UseCases\UseCaseInterface;

class FetchExternalMessageUseCase implements UseCaseInterface
{
    public function __construct(private readonly ExternalServiceClientInterface $client)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function handle(mixed $input = null): array
    {
        return $this->client->fetch();
    }
}

