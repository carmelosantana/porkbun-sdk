<?php

declare(strict_types=1);

namespace PorkbunSdk;

class Ping extends PorkbunApi
{
    /**
     * Ping the Porkbun API to verify connectivity and credentials.
     *
     * This method checks the API connection and returns your IP address as recognized by the Porkbun API.
     *
     * @return array The response from the API, including the status and your IP address.
     * @throws \Exception If the API request fails.
     */
    public function ping(): array
    {
        $endpoint = '/ping';
        return $this->sendRequest($endpoint);
    }
}
