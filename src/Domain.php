<?php

declare(strict_types=1);

namespace PorkbunSdk;

class Domain extends PorkbunApi
{
    /**
     * Update the name servers for your domain.
     *
     * @param string $domain The domain name.
     * @param array $name_servers An array of name servers to update your domain with.
     * @return array The response from the API.
     * @throws \Exception If the API request fails.
     */
    public function updateNameServers(string $domain, array $name_servers): array
    {
        $endpoint = '/domain/updateNs/' . $domain;
        $data = [
            'ns' => $name_servers,
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Get the authoritative name servers listed at the registry for your domain.
     *
     * @param string $domain The domain name.
     * @return array The response from the API, including an array of name server host names.
     * @throws \Exception If the API request fails.
     */
    public function getNameServers(string $domain): array
    {
        $endpoint = '/domain/getNs/' . $domain;
        return $this->sendRequest($endpoint);
    }

    /**
     * Get all domain names in the account. Domains are returned in chunks of 1000.
     *
     * @param int $start Optional. An index to start at when retrieving the domains, defaults to 0.
     * @param string $include_labels Optional. If set to "yes", label information for the domains will be returned if it exists.
     * @return array The response from the API, including an array of domains and domain details.
     * @throws \Exception If the API request fails.
     */
    public function listAllDomains(int $start = 0, string $include_labels = 'no'): array
    {
        $endpoint = '/domain/listAll';
        $data = [
            'start' => $start,
            'includeLabels' => $include_labels,
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Add URL forward for a domain.
     *
     * @param string $domain The domain name.
     * @param string $location The URL to forward the domain to.
     * @param string $type Optional. The type of forward. Valid types are: temporary or permanent.
     * @param string $include_path Optional. Whether to include the URI path in the redirection. Valid options are yes or no.
     * @param string $wildcard Optional. Also forward all subdomains of the domain. Valid options are yes or no.
     * @param string $subdomain Optional. A subdomain to add URL forwarding for. Leave this blank to forward the root domain.
     * @return array The response from the API.
     * @throws \Exception If the API request fails.
     */
    public function addUrlForward(
        string $domain,
        string $location,
        string $type = 'temporary',
        string $include_path = 'no',
        string $wildcard = 'yes',
        string $subdomain = ''
    ): array {
        $endpoint = '/domain/addUrlForward/' . $domain;
        $data = [
            'subdomain' => $subdomain,
            'location' => $location,
            'type' => $type,
            'includePath' => $include_path,
            'wildcard' => $wildcard,
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Get URL forwarding for a domain.
     *
     * @param string $domain The domain name.
     * @return array The response from the API, including an array of forwarding records for the domain.
     * @throws \Exception If the API request fails.
     */
    public function getUrlForwarding(string $domain): array
    {
        $endpoint = '/domain/getUrlForwarding/' . $domain;
        return $this->sendRequest($endpoint);
    }

    /**
     * Delete a URL forward for a domain.
     *
     * @param string $domain The domain name.
     * @param int $record_id The record ID of the URL forward to delete.
     * @return array The response from the API.
     * @throws \Exception If the API request fails.
     */
    public function deleteUrlForward(string $domain, int $record_id): array
    {
        $endpoint = '/domain/deleteUrlForward/' . $domain . '/' . $record_id;
        return $this->sendRequest($endpoint);
    }
}
