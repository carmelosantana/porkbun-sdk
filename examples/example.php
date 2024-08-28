<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use PorkbunSdk\Domain;

$apiKey = 'YOUR_API_KEY';
$secretApiKey = 'YOUR_SECRET_API_KEY';

$domainApi = new Domain($apiKey, $secretApiKey);

try {
    $response = $domainApi->listAllDomains();

    echo 'List of domains: ' . PHP_EOL;
    print_r($response);
} catch (Exception $e) {
    echo 'Failed to retrieve domains: ' . $e->getMessage();
}
