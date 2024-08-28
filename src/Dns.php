<?php

declare(strict_types=1);

namespace PorkbunSdk;

class DNS extends PorkbunApi
{
    /**
     * Create a DNS record.
     *
     * @param string $domain The domain name.
     * @param string $type The type of record being created (e.g., A, MX, CNAME, etc.).
     * @param string $content The answer content for the record.
     * @param string $name Optional. The subdomain for the record being created. Leave blank to create a record on the root domain.
     * @param int $ttl Optional. The time to live in seconds for the record. Default is 600 seconds.
     * @param int $prio Optional. The priority of the record for those that support it.
     * @return array The response from the API, including the ID of the record created.
     * @throws \Exception If the API request fails.
     */
    public function createRecord(
        string $domain,
        string $type,
        string $content,
        string $name = '',
        int $ttl = 600,
        int $prio = 0
    ): array {
        $endpoint = '/dns/create/' . $domain;
        $data = [
            'name' => $name,
            'type' => $type,
            'content' => $content,
            'ttl' => $ttl,
            'prio' => $prio,
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Edit a DNS record by domain and ID.
     *
     * @param string $domain The domain name.
     * @param int $id The ID of the DNS record to edit.
     * @param string $type The type of record being created (e.g., A, MX, CNAME, etc.).
     * @param string $content The answer content for the record.
     * @param string $name Optional. The subdomain for the record being created. Leave blank to create a record on the root domain.
     * @param int $ttl Optional. The time to live in seconds for the record. Default is 600 seconds.
     * @param int $prio Optional. The priority of the record for those that support it.
     * @return array The response from the API.
     * @throws \Exception If the API request fails.
     */
    public function editRecord(
        string $domain,
        int $id,
        string $type,
        string $content,
        string $name = '',
        int $ttl = 600,
        int $prio = 0
    ): array {
        $endpoint = '/dns/edit/' . $domain . '/' . $id;
        $data = [
            'name' => $name,
            'type' => $type,
            'content' => $content,
            'ttl' => $ttl,
            'prio' => $prio,
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Delete a specific DNS record by domain and ID.
     *
     * @param string $domain The domain name.
     * @param int $id The ID of the DNS record to delete.
     * @return array The response from the API.
     * @throws \Exception If the API request fails.
     */
    public function deleteRecord(string $domain, int $id): array
    {
        $endpoint = '/dns/delete/' . $domain . '/' . $id;
        return $this->sendRequest($endpoint);
    }

    /**
     * Retrieve all editable DNS records associated with a domain.
     *
     * @param string $domain The domain name.
     * @return array The response from the API, including an array of DNS records.
     * @throws \Exception If the API request fails.
     */
    public function retrieveRecords(string $domain): array
    {
        $endpoint = '/dns/retrieve/' . $domain;
        return $this->sendRequest($endpoint);
    }

    /**
     * Retrieve a single DNS record by domain and ID.
     *
     * @param string $domain The domain name.
     * @param int $id The ID of the DNS record to retrieve.
     * @return array The response from the API, including the DNS record details.
     * @throws \Exception If the API request fails.
     */
    public function retrieveRecordById(string $domain, int $id): array
    {
        $endpoint = '/dns/retrieve/' . $domain . '/' . $id;
        return $this->sendRequest($endpoint);
    }
}
