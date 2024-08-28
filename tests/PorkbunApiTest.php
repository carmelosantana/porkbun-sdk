<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\PorkbunApi;

// extend sendRequest method to be public for testing
class TestablePorkbunApi extends PorkbunApi
{
    public function sendRequest(string $endpoint, array $data = []): array
    {
        return parent::sendRequest($endpoint, $data);
    }
}

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it sends a successful request to the Porkbun API', function () {
    // Mock the HTTP response based on documentation example
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'pricing' => [
                'com' => [
                    'registration' => '9.68',
                    'renewal' => '9.68',
                    'transfer' => '9.68'
                ]
            ]
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the TestablePorkbunApi class with the mocked client
    $api = new TestablePorkbunApi($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $api->sendRequest('/pricing/get');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['pricing']['com']['registration'])->toBe('9.68');
    expect($response['pricing']['com']['renewal'])->toBe('9.68');
    expect($response['pricing']['com']['transfer'])->toBe('9.68');
});

test('it handles API errors correctly', function () {
    // Mock the HTTP response based on documentation example
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'ERROR',
            'message' => 'All HTTP request must use POST.'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the TestablePorkbunApi class with the mocked client
    $api = new TestablePorkbunApi($this->apiKey, $this->secretApiKey, $client);

    // Act & Assert
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('API Error: All HTTP request must use POST.');

    $api->sendRequest('/invalid/endpoint');
});

test('it handles authentication correctly', function () {
    // Mock the HTTP response for authentication testing
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'yourIp' => '127.0.0.1'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the TestablePorkbunApi class with the mocked client
    $api = new TestablePorkbunApi($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $api->sendRequest('/ping');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['yourIp'])->toBe('127.0.0.1');
});

test('it handles non-200 HTTP responses as errors', function () {
    // Mock the HTTP response with a 403 status code
    $mock = new MockHandler([
        new Response(403, [], json_encode([
            'status' => 'ERROR',
            'message' => 'Forbidden access, additional authentication required.'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the TestablePorkbunApi class with the mocked client
    $api = new TestablePorkbunApi($this->apiKey, $this->secretApiKey, $client);

    // Act & Assert
    try {
        $api->sendRequest('/restricted/endpoint');
    } catch (\Exception $e) {
        expect($e->getMessage())->toContain('Forbidden access, additional authentication required.');
        expect($e->getMessage())->toContain('403 Forbidden');
    }
});
