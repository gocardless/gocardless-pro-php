# GoCardless Pro PHP client library

A PHP client for interacting with the GoCardless Pro API.

- [API Documentation](https://developer.gocardless.com/pro/2015-07-06)
- [Composer Package](https://packagist.org/packages/gocardless/gocardless-pro)

### Installation

The recommended way to install `gocardless-pro` is using [Composer](https://getcomposer.org/).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of `gocardless-pro`.
```bash
php composer.phar require gocardless/gocardless-pro-php
```

After installing, you need to require Composer's autoloader:
```php
require 'vendor/autoload.php';
```

### Initialising A Client

Create a `GoCardlessPro\Client` instance, providing your access token and the environment you want to use.
We strongly advise storing your access token as an environment variable, rather than directly in your code. you can easily load the environment variables from a `.env` file by using something like [phpdotenv](https://github.com/vlucas/phpdotenv), though keep it out of version control!

```php
$access_token = getenv('GC_ACCESS_TOKEN');
$client = new \GoCardlessPro\Client(array(
  'access_token' => $access_token,
  'environment'  => \GoCardlessPro\Environment::SANDBOX
));
```

Your `access_token` can be found under the "Developer" tab in your GoCardless dashboard.

The environment can either be `\GoCardlessPro\Environment::SANDBOX` or `\GoCardlessPro\Environment::PRODUCTION`, depending on whether you want to use the sandbox or production API.

For full documentation, see our [API docs](https://developer.gocardless.com/pro/2015-07-06).

### GET requests

You can make a request to get a list of resources using the `list` method.

```php
$client->customers()->list();
```

*Note: This README will use customers throughout but each of the resources in the API is available in this library.*

If you need to pass any options, the last (or only, in the absence of URL params) argument to `list()` is an array of URL parameters:

```php
$customers = $client->customers()->list(['params' => ['limit' => 400]]);
```

A call to `list()` returns an instance of `ListResponse`. You can use it's `records` attribute to iterate through the results.

```php
echo count($customers->records);
foreach ($customers->records as $resource) {
  echo $resource->given_name;
}
```

In the case where a URL parameter is needed, the method signature will contain the required arguments:

```php
$customer = $client->customers()->get($customer_id);
echo $customer->given_name;
```

As with list, the last argument can be an options array, with any URL parameters given:

```php
$client->customers.get(customers_id, ['params' => ['some_flag' => true]]);
```

Both individual resource and ListResponse instances have an `api_response` attribute, which lets you access the following properties of the request:

- `status`
- `headers`
- `body`

### POST/PUT Requests

For POST and PUT requests, you need to provide a body for your request by passing it in as the first argument.

```php
$client->customer()->create([
  'params' => ["given_name" => "Pete", "family_name" => "Hamilton"]
]);
```

As with GET requests, if any parameters are required, these come first:

```php
$client->customer()->update($customer_id, [...]);
```

### Handling Failures

When the API returns an error, the library will return a corresponding subclass of `ApiException`, one of:

- `GoCardlessProException`
- `InvalidApiUsageException`
- `InvalidStateException`
- `ValidationFailedException`

These types of error are all covered in the [API documentation](https://developer.gocardless.com/pro/#overview-errors).

If the error is an HTTP transport layer error (e.g. cannot connect, empty response from server, etc.), the client will throw an `ApiConnectionException`. If it can't parse the response from GoCardless, it will throw a `MalformedResponseException

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

## Supporting PHP < 5.5

This client library only supports PHP >= 5.5

## Contributing

This client is auto-generated from Crank, a toolchain that we hope to soon open source.
Issues should for now be reported on this repository.

**Please do not modify the source code yourself, your changes will be overriden!**
