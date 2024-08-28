<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\Ssl;

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it retrieves SSL certificate bundle by domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'certificatechain' => '----BEGIN CERTIFICATE-----\n...-----END CERTIFICATE-----\n',
            'privatekey' => '-----BEGIN PRIVATE KEY-----\n...-----END PRIVATE KEY-----\n',
            'publickey' => '-----BEGIN PUBLIC KEY-----\n...-----END PUBLIC KEY-----\n',
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Ssl class with the mocked client
    $ssl = new Ssl($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $ssl->retrieveBundleByDomain('example.com');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['certificatechain'])->toContain('BEGIN CERTIFICATE');
    expect($response['privatekey'])->toContain('BEGIN PRIVATE KEY');
    expect($response['publickey'])->toContain('BEGIN PUBLIC KEY');
});
