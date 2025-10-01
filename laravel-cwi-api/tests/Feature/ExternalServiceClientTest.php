<?php

use App\Services\ExternalServiceClient;
use App\Exceptions\External\ExternalServiceException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Config::set('services.node_ms.base_url', 'http://localhost:3000');
    Config::set('services.node_ms.timeout', 30);
});

test('can fetch data from external service successfully', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response(['message' => 'I\'m running with Node.js and Express!'], 200)
    ]);

    $client = new ExternalServiceClient();
    $result = $client->fetch();

    expect($result)->toBe(['message' => 'I\'m running with Node.js and Express!']);
    
    Http::assertSent(function ($request) {
        return $request->url() === 'http://localhost:3000/' &&
               $request->method() === 'GET';
    });
});

test('throws ExternalServiceException when external service fails', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response([], 500)
    ]);

    $client = new ExternalServiceClient();
    
    expect(fn() => $client->fetch())
        ->toThrow(ExternalServiceException::class);
});

test('throws ExternalServiceException when request times out', function () {
    Http::fake([
        'http://localhost:3000/' => function () {
            throw new ConnectionException('Request timed out');
        }
    ]);

    $client = new ExternalServiceClient();
    
    expect(fn() => $client->fetch())
        ->toThrow(ExternalServiceException::class);
});

test('throws ExternalServiceException when external service is unreachable', function () {
    Http::fake([
        'http://localhost:3000/' => function () {
            throw new ConnectionException('Connection refused');
        }
    ]);

    $client = new ExternalServiceClient();
    
    expect(fn() => $client->fetch())
        ->toThrow(ExternalServiceException::class);
});

test('uses correct configuration for HTTP client', function () {
    Config::set('services.node_ms.base_url', 'http://test-service:8080');
    Config::set('services.node_ms.timeout', 60);

    Http::fake([
        'http://test-service:8080/' => Http::response(['test' => 'data'], 200)
    ]);

    $client = new ExternalServiceClient();
    $result = $client->fetch();

    expect($result)->toBe(['test' => 'data']);
    
    Http::assertSent(function ($request) {
        return $request->url() === 'http://test-service:8080/' &&
               $request->method() === 'GET';
    });
});

test('handles empty response from external service', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response([], 200)
    ]);

    $client = new ExternalServiceClient();
    $result = $client->fetch();

    expect($result)->toBe([]);
});

test('handles malformed JSON response', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response('invalid json', 200)
    ]);

    $client = new ExternalServiceClient();
    $result = $client->fetch();

    expect($result)->toBe([]);
});
