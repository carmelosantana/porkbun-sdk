<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\Ping;

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it pings the API successfully', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'yourIp' => '127.0.0.1'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Ping class with the mocked client
    $ping = new Ping($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $ping->ping();

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['yourIp'])->toBe('127.0.0.1');
});

test('it throws an exception on ping API error', function () {
    // Mock the HTTP response with an error
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'ERROR',
            'message' => 'Invalid API Key'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Ping class with the mocked client
    $ping = new Ping($this->apiKey, $this->secretApiKey, $client);

    // Act & Assert
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('API Error: Invalid API Key');

    $ping->ping();
});
