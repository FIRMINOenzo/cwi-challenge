<?php

namespace App\Services;

use App\Contracts\Services\ExternalServiceClientInterface;
use App\Exceptions\External\ExternalServiceException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

class ExternalServiceClient implements ExternalServiceClientInterface
{
    private function httpClient()
    {
        return Http::baseUrl(Config::get('services.node_ms.base_url'))
            ->timeout((int) Config::get('services.node_ms.timeout'))
            ->retry(3, 100);
    }

    public function fetch(): array
    {
        try {
            $response = $this->httpClient()->get('/')->throw();
            $json = $response->json();
            return is_array($json) ? $json : [];
        } catch (RequestException|ConnectionException $exception) {
            throw new ExternalServiceException();
        }
    }
}
