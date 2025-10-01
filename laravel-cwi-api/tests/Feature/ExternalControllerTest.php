<?php

use App\UseCases\External\FetchExternalMessageUseCase;
use App\Exceptions\External\ExternalServiceException;
use Illuminate\Support\Facades\Http;

test('can fetch external message successfully', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response(['message' => 'I\'m running with Node.js and Express!'], 200)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(200)
        ->assertJson(['message' => 'I\'m running with Node.js and Express!']);
});

test('returns 500 when external service fails', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response([], 500)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(500)
        ->assertJson(['message' => 'External service request failed.']);
});

test('returns 500 when external service times out', function () {
    Http::fake([
        'http://localhost:3000/' => function () {
            throw new \Illuminate\Http\Client\ConnectionException('Request timed out');
        }
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(500)
        ->assertJson(['message' => 'External service request failed.']);
});

test('returns 500 when external service is unreachable', function () {
    Http::fake([
        'http://localhost:3000/' => function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection refused');
        }
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(500)
        ->assertJson(['message' => 'External service request failed.']);
});

test('handles empty response from external service', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response([], 200)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(200)
        ->assertJson([]);
});

test('handles complex response structure from external service', function () {
    $complexResponse = [
        'message' => 'Success',
        'data' => [
            'id' => 123,
            'name' => 'Test Service',
            'status' => 'active'
        ],
        'timestamp' => '2024-01-01T00:00:00Z'
    ];

    Http::fake([
        'http://localhost:3000/' => Http::response($complexResponse, 200)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(200)
        ->assertJson($complexResponse);
});

test('uses correct HTTP method and endpoint', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response(['test' => 'data'], 200)
    ]);

    $this->getJson('/api/external');

    Http::assertSent(function ($request) {
        return $request->url() === 'http://localhost:3000/' &&
               $request->method() === 'GET';
    });
});

test('response has correct content type', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response(['message' => 'test'], 200)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertHeader('Content-Type', 'application/json');
});

test('handles malformed JSON response gracefully', function () {
    Http::fake([
        'http://localhost:3000/' => Http::response('invalid json', 200)
    ]);

    $response = $this->getJson('/api/external');

    $response->assertStatus(200);
    expect($response->json())->toBe([]);
});
