<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PorkbunSdk\Domain;

beforeEach(function () {
    $this->apiKey = 'test_api_key';
    $this->secretApiKey = 'test_secret_api_key';
});

test('it updates name servers for a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode(['status' => 'SUCCESS']))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->updateNameServers('example.com', ['ns1.example.com', 'ns2.example.com']);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
});

test('it retrieves name servers for a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'ns' => ['ns1.example.com', 'ns2.example.com']
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->getNameServers('example.com');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['ns'])->toEqual(['ns1.example.com', 'ns2.example.com']);
});

test('it lists all domains', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'domains' => [
                [
                    'domain' => 'example.com',
                    'status' => 'ACTIVE'
                ],
                [
                    'domain' => 'anotherexample.com',
                    'status' => 'ACTIVE'
                ]
            ]
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->listAllDomains();

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['domains'])->toBeArray();
    expect($response['domains'][0]['domain'])->toBe('example.com');
});

test('it adds URL forward for a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode(['status' => 'SUCCESS']))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->addUrlForward('example.com', 'https://forwarded.com', 'temporary', 'no', 'yes', '');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
});

test('it retrieves URL forwarding for a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'status' => 'SUCCESS',
            'forwards' => [
                [
                    'id' => '123456',
                    'subdomain' => '',
                    'location' => 'https://forwarded.com',
                    'type' => 'temporary'
                ]
            ]
        ]))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->getUrlForwarding('example.com');

    // Assert
    expect($response['status'])->toBe('SUCCESS');
    expect($response['forwards'])->toBeArray();
    expect($response['forwards'][0]['location'])->toBe('https://forwarded.com');
});

test('it deletes a URL forward for a domain', function () {
    // Mock the HTTP response
    $mock = new MockHandler([
        new Response(200, [], json_encode(['status' => 'SUCCESS']))
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    // Initialize the Domain class with the mocked client
    $domain = new Domain($this->apiKey, $this->secretApiKey, $client);

    // Act
    $response = $domain->deleteUrlForward('example.com', 123456);

    // Assert
    expect($response['status'])->toBe('SUCCESS');
});
