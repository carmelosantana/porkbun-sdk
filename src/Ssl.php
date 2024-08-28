<?php

declare(strict_types=1);

namespace PorkbunSdk;

class Ssl extends PorkbunApi
{
    /**
     * Retrieve the SSL certificate bundle for the domain.
     *
     * This method retrieves the SSL certificate chain, private key, and public key associated with a domain.
     *
     * @param string $domain The domain name for which to retrieve the SSL certificate bundle.
     * @return array The response from the API, including the certificate chain, private key, and public key.
     * @throws \Exception If the API request fails.
     */
    public function retrieveBundleByDomain(string $domain): array
    {
        $endpoint = '/ssl/retrieve/' . $domain;
        return $this->sendRequest($endpoint);
    }
}
