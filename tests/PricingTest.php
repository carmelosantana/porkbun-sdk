<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\Pricing;

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it retrieves pricing information successfully', function () {
    // Mock the HTTP response
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

    // Initialize the Pricing class with the mocked client
    $pricing = new Pricing($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $pricing->getPricing();

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['pricing']['com']['registration'])->toBe('9.68');
    expect($response['pricing']['com']['renewal'])->toBe('9.68');
    expect($response['pricing']['com']['transfer'])->toBe('9.68');
});

test('it throws an exception on pricing API error', function () {
    // Mock the HTTP response with an error
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'ERROR',
            'message' => 'Invalid request'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Pricing class with the mocked client
    $pricing = new Pricing($this->apiKey, $this->secretApiKey, $client);

    // Act & Assert
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('API Error: Invalid request');

    $pricing->getPricing();
});
