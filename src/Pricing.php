<?php

declare(strict_types=1);

namespace PorkbunSdk;

class Pricing extends PorkbunApi
{
    /**
     * Get domain pricing information for all supported TLDs.
     *
     * This method retrieves the pricing for domain registration, renewal, and transfer.
     *
     * @return array The response from the API, including pricing details for each TLD.
     * @throws \Exception If the API request fails.
     */
    public function getPricing(): array
    {
        $endpoint = '/pricing/get';
        return $this->sendRequest($endpoint);
    }
}
