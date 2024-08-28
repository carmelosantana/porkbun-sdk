<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\DNS;

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it creates a DNS record', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'id' => '123456'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the DNS class with the mocked client
    $dns = new DNS($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $dns->createRecord('example.com', 'A', '1.1.1.1', 'www', 600);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['id'])->toBe('123456');
});

test('it edits a DNS record by domain and ID', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the DNS class with the mocked client
    $dns = new DNS($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $dns->editRecord('example.com', 123456, 'A', '1.1.1.2', 'www', 600);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
});

test('it deletes a DNS record by domain and ID', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS'
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the DNS class with the mocked client
    $dns = new DNS($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $dns->deleteRecord('example.com', 123456);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
});

test('it retrieves all DNS records associated with a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'records' => [
                [
                    'id' => '123456',
                    'name' => 'www',
                    'type' => 'A',
                    'content' => '1.1.1.1',
                    'ttl' => '600',
                    'prio' => '0'
                ],
                [
                    'id' => '123457',
                    'name' => 'mail',
                    'type' => 'MX',
                    'content' => 'mail.example.com',
                    'ttl' => '600',
                    'prio' => '10'
                ]
            ]
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the DNS class with the mocked client
    $dns = new DNS($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $dns->retrieveRecords('example.com');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['records'])->toBeArray();
    expect($response['records'][0]['name'])->toBe('www');
    expect($response['records'][1]['name'])->toBe('mail');
});

test('it retrieves a single DNS record by domain and ID', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'records' => [
                [
                    'id' => '123456',
                    'name' => 'www',
                    'type' => 'A',
                    'content' => '1.1.1.1',
                    'ttl' => '600',
                    'prio' => '0'
                ]
            ]
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the DNS class with the mocked client
    $dns = new DNS($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $dns->retrieveRecordById('example.com', 123456);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['records'])->toBeArray();
    expect($response['records'][0]['name'])->toBe('www');
    expect($response['records'][0]['content'])->toBe('1.1.1.1');
});
