<?php

declare(strict_types=1);

namespace PorkbunSdk;

use GuzzleHttp\Client;

class PorkbunApi
{
    /**
     * The base URL for the Porkbun API.
     * 
     * @var string
     */
    private string $api_url = 'https://api.porkbun.com/api/json/v3';

    /**
     * The HTTP client used to send requests to the API.
     * 
     * @var Client
     */
    private Client $http_client;

    /**
     * PorkbunApi constructor.
     *
     * Initializes the API with the provided API key, secret API key, and an optional HTTP client.
     *
     * @param string $api_key Your Porkbun API key.
     * @param string $secret_api_key Your Porkbun secret API key.
     * @param Client|null $http_client Optional. A custom HTTP client. Defaults to Guzzle's Client if not provided.
     */
    public function __construct(
        public string $api_key,
        public string $secret_api_key,
        Client $http_client = null
    ) {
        $this->http_client = $http_client ?: new Client();
    }

    /**
     * Sends a POST request to the Porkbun API.
     *
     * This method constructs the full API endpoint URL, adds the API key and secret key to the request data,
     * and sends the request using the provided HTTP client. It then decodes the JSON response.
     *
     * @param string $endpoint The specific API endpoint to send the request to.
     * @param array $data Optional. The data to be sent in the request body. Defaults to an empty array.
     * @return array The decoded response from the API.
     * @throws \Exception If the API response indicates an error.
     */
    protected function sendRequest(string $endpoint, array $data = []): array
    {
        $url = $this->api_url . $endpoint;
        $data['apikey'] = $this->api_key;
        $data['secretapikey'] = $this->secret_api_key;

        $response = $this->http_client->post($url, [
            'json' => $data
        ]);

        $decoded_response = json_decode($response->getBody()->getContents(), true);

        if ($decoded_response['status'] !== 'SUCCESS') {
            throw new \Exception('API Error: ' . $decoded_response['message']);
        }

        return $decoded_response;
    }
}
