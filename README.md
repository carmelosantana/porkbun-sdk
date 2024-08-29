# Porkbun SDK for PHP

PHP library for interacting with the [Porkbun](https://porkbun.com) API.

- [Install](#install)
- [Usage](#usage)
  - [Domain](#domain)
  - [DNS](#dns)
  - [SSL](#ssl)
- [Testing](#testing)
- [Support](#support)
- [Funding](#funding)
- [Changelog](#changelog)
- [License](#license)

---

**Supports**

Interactions with [Porkbun's](https://porkbun.com) API for;

- Domain management
- DNS record management
- SSL certificate retrieval

**Features**

- Manage domains: Update name servers, list domains, and more.
- Handle DNS records: Create, edit, retrieve, and delete DNS records.
- Manage SSL certificates: Retrieve SSL certificate bundles for your domains.

## Install

Include `PorkbunSdk` in your project with [Composer](https://getcomposer.org/):

```bash
composer require carmelosantana/porkbun-sdk
```

**Requirements:**

- [PHP](https://www.php.net/manual/en/install.php) 8.1 or above
- [Composer](https://getcomposer.org/)

## Usage

To use the [Porkbun](https://porkbun.com) API, you need to have an API key and secret from [Porkbun](https://porkbun.com). You can obtain these by logging into your [Porkbun](https://porkbun.com) account and [generating an API key](https://kb.porkbun.com/article/190-getting-started-with-the-porkbun-api).

### Domain

✅ Update the name servers for a domain.

```php
$domain = new PorkbunSdk\Domain('your_api_key', 'your_secret_api_key');

$response = $domain->updateNameServers('example.com', [
    'ns1.example.com',
    'ns2.example.com'
]);

print_r($response);
```

### DNS

✅ Create a new DNS A record for a domain.

```php
$dns = new PorkbunSdk\DNS('your_api_key', 'your_secret_api_key');

$response = $dns->createRecord('example.com', 'A', '1.1.1.1', 'www');

print_r($response);
```

### SSL

✅ Retrieve the SSL certificate bundle for a domain.

```php
$ssl = new PorkbunSdk\SSL('your_api_key', 'your_secret_api_key');

$response = $ssl->getCertificate('example.com');

print_r($response);
```

## Testing

To run the test suite:

```bash
composer test
```

**Requirements:**

- [Pest](https://pestphp.com/) is used for testing.

## Support

Community support is available on [Discord](https://discord.gg/vZunFRuDvB).

## Funding

If you find this project useful or use it in a commercial environment, please consider donating:

- Bitcoin: `bc1qhxu9yf9g5jkazy6h4ux6c2apakfr90g2rkwu45`
- Ethereum: `0x9f5D6dd018758891668BF2AC547D38515140460f`
- Patreon: [patreon.com/carmelosantana](https://www.patreon.com/carmelosantana)
- PayPal: [Donate via PayPal](https://www.paypal.com/donate?hosted_button_id=WHCW333MC7CNW)

## Changelog

- **1.0.0** - Aug 29, 2024
  - Initial release of the `PorkbunSdk` library with support for Domain, DNS, and SSL management.

## License

Code and documentation are released under the [MIT License](https://opensource.org/licenses/MIT).
