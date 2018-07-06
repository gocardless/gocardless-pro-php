# GoCardless Pro PHP client library

A PHP client for interacting with the GoCardless Pro API.

[![PHP version](https://badge.fury.io/ph/gocardless%2Fgocardless-pro.svg)](https://badge.fury.io/ph/gocardless%2Fgocardless-pro)
[![CircleCI](https://circleci.com/gh/gocardless/gocardless-pro-php.svg?style=shield)](https://circleci.com/gh/gocardless/gocardless-pro-php)


- ["Getting started" guide](https://developer.gocardless.com/getting-started/api/introduction/?lang=php)
with copy and paste PHP code samples
- [API Reference](https://developer.gocardless.com/api-reference)
- [Composer Package](https://packagist.org/packages/gocardless/gocardless-pro)
- [Changelog](https://github.com/gocardless/gocardless-pro-php/releases)

### Installation

The recommended way to install `gocardless-pro` is using
[Composer](https://getcomposer.org/).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of `gocardless-pro`.
```bash
php composer.phar require gocardless/gocardless-pro
```

After installing, you need to require Composer's autoloader:
```php
require 'vendor/autoload.php';
```

#### Manual installation

We strongly recommend using [Composer](https://getcomposer.org/) - it'll make it easier
to manage your dependencies and stay up to date. But if you don't want to, you can also
install the library manually:

* Make sure you have PHP's [cURL](http://php.net/manual/en/curl.installation.php),
[JSON](http://php.net/manual/en/json.installation.php) and
[mbstring](http://php.net/manual/en/mbstring.installation.php) extensions enabled
(Composer checks these dependencies automatically)
* Download the latest zipped release of
[Guzzle](https://github.com/guzzle/guzzle/releases), which we use for making HTTP
requests, and `require` the `autoloader.php` file
* Grab the PHP library's
[source](https://github.com/gocardless/gocardless-pro-php/archive/master.zip), and
`require` the `lib/loader.php` file

### Initialising A Client

Create a `GoCardlessPro\Client` instance, providing your access token and the environment
you want to use. We strongly advise storing your access token as an environment variable,
rather than directly in your code. you can easily load the environment variables from a
`.env` file by using something like [phpdotenv](https://github.com/vlucas/phpdotenv),
though keep it out of version control!

```php
$access_token = getenv('GC_ACCESS_TOKEN');
$client = new \GoCardlessPro\Client(array(
  'access_token' => $access_token,
  'environment'  => \GoCardlessPro\Environment::SANDBOX
));
```

You can create an `access_token` from the "Developers" tab in your GoCardless dashboard.

The environment can either be `\GoCardlessPro\Environment::SANDBOX` or
`\GoCardlessPro\Environment::LIVE`, depending on whether you want to
use the sandbox or live API.

For full documentation, see our [API docs](https://developer.gocardless.com/api-reference).

### GET requests

You can make a request to get a list of resources using the `list` method.

```php
$client->customers()->list();
```

*Note: This README will use customers throughout but each of the resources in the API is
available in this library.*

If you need to pass any options, the last (or only, in the absence of URL params)
argument to `list()` is an array of URL parameters:

```php
$customers = $client->customers()->list(['params' => ['limit' => 400]]);
```

A call to `list()` returns an instance of `ListResponse`. You can use its `records`
attribute to iterate through the results.

```php
echo count($customers->records);
foreach ($customers->records as $resource) {
  echo $resource->given_name;
}
```

In the case where a URL parameter is needed, the method signature will contain the
required arguments:

```php
$customer = $client->customers()->get($customer_id);
echo $customer->given_name;
```

As with list, the last argument can be an options array, with any URL parameters given:

```php
$client->customers()->get($customer_id, ['params' => ['some_flag' => true]]);
```

Both individual resource and ListResponse instances have an `api_response` attribute,
which lets you access the following properties of the request:

- `status`
- `headers`
- `body`

```php
$api_response = $client->customers()->get($customer_id)->api_response;
echo $api_response->status_code;
```

### POST/PUT Requests

For POST and PUT requests, you need to provide a body for your request by passing it in
as the first argument.

```php
$client->customers()->create([
  'params' => ["given_name" => "Pete", "family_name" => "Hamilton"]
]);
```

As with GET requests, if any parameters are required, these come first:

```php
$client->customers()->update($customer_id, [
  'params' => ["family_name" => "Smith"]
]);
```

The GoCardless API includes [idempotency keys](https://developer.gocardless.com/api-reference/#making-requests-idempotency-keys).
The library will automatically inject these into your request when you create a resource,
preventing it from getting duplicated if something goes wrong with the API (e.g.
networking issues or a timeout).

You can also specify your own idempotency key - you
could, for example, use IDs of records in your database, protecting yourself not only
from network or API issues, but also mistakes on your side which could lead to
double-creation:

```php
$client->customers()->create([
  'params' => ["given_name" => "Pete", "family_name" => "Hamilton"]
  "headers" => ["Idempotency-Key" => "ABC123"]
]);
```

If the library hits an idempotency key conflict (that is, you try to create a resource
with an idempotency key you've already used), it will automatically load and return the
already-existing resource.

### Handling Failures

When the API returns an error, the library will return a corresponding subclass of
`ApiException`, one of:

- `InvalidApiUsageException`
- `InvalidStateException`
- `ValidationFailedException`

These types of error are covered in the
[API documentation](https://developer.gocardless.com/pro/#overview-errors).

If the error is an HTTP transport layer error (e.g. timeouts or issues within
GoCardless's infrastructure), requests will automatically be retried by the library up to
3 times, with a 500ms delay between attempts, before a `ApiConnectionException` is
raised.

If the library can't parse the response from GoCardless, it will throw a
`MalformedResponseException`.

```php
try {
  $client->customer()->create(array(
    "params" => array("invalid_name" => "Pete")
  ));
} catch (\GoCardlessPro\Core\Exception\ApiException $e) {
  // Api request failed / record couldn't be created.
} catch (\GoCardlessPro\Core\Exception\MalformedResponseException $e) {
  // Unexpected non-JSON response
} catch (\GoCardlessPro\Core\Exception\ApiConnectionException $e) {
  // Network error
}
```

Properties of the exception can be accessesed with the following methods:
- `$e->getType();`
- `$e->getCode();`
- `$e->getErrors();`
- `$e->getDocumentationUrl();`
- `$e->getMessage();`
- `$e->getRequestId();`
- `$e->getApiResponse();`

### Handling webhooks

GoCardless supports webhooks, allowing you to receive real-time notifications when things happen in your account, so you can take automatic actions in response, for example:

* When a customer cancels their mandate with the bank, suspend their club membership
* When a payment fails due to lack of funds, mark their invoice as unpaid
* When a customer’s subscription generates a new payment, log it in their “past payments” list

The client allows you to validate that a webhook you receive is genuinely from GoCardless, and to parse it into `GoCardlessPro\Resources\Event` objects which are easy to work with:

```ruby
<?php
// When you create a webhook endpoint, you can specify a secret. When GoCardless sends
// you a webhook, it'll sign the body using that secret. Since only you and GoCardless
// know the secret, you can check the signature and ensure that the webhook is truly
// from GoCardless.
//
// We recommend storing your webhook endpoint secret in an environment variable
// for security, but you could include it as a string directly in your code
$webhook_endpoint_secret = getenv("GOCARDLESS_WEBHOOK_ENDPOINT_SECRET");

$request_body = file_get_contents('php://input');

$headers = getallheaders();
$signature_header = $headers["Webhook-Signature"];

try {
     $events = GoCardlessPro\Webhook::parse($request_body, $signature_header, $webhook_endpoint_secret);

     foreach ($events as $event) {
         // You can access each event in the webhook.
         echo($event->id);
     }

     header("HTTP/1.1 200 OK");
} catch (GoCardlessPro\Core\Exception\InvalidSignatureException) {
     // The webhook doesn't appear to be genuinely from GoCardless, as the signature
     // included in the `Webhook-Signature` header doesn't match one computed with your
     // webhook endpoint secret and the body
     header("HTTP/1.1 498 Invalid Token");
}
```

For more details on working with webhooks, see our ["Getting started" guide](https://developer.gocardless.com/getting-started/api/introduction/?lang=php).

## Supporting PHP >= 5.6

This client library only supports PHP >= 5.6. Earlier releases of PHP are now considered
[end of life](http://php.net/supported-versions.php) and may be exposed to security
vunerabilities.

## Contributing

This client is auto-generated from Crank, a toolchain that we hope to soon open source.
Issues should for now be reported on this repository.

**Please do not modify the source code yourself, your changes will be overriden!**
