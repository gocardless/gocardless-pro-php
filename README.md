# PHP Client for GoCardless Enterprise API

- [PHP Doc API Doc](http://gocardless.github.io/gocardless-pro-php/)
- [GoCardless Pro API Docs](https://developer.gocardless.com/pro/)
- [Composer Package](https://packagist.org/packages/gocardless/gocardless-pro-php)

### Installation

The files you need to use the client library are in the `/lib` folder.

To load the library, you only need to require the `lib/loader.php` file. If you're using [Composer](https://getcomposer.org/), you should rely on Composer's autoload functionality.

#### Install from source

```console
$ git clone git://github.com/gocardless/gocardless-pro-php.git
```

#### Installing from the tarball

```console
$ curl -L https://github.com/gocardless/gocardless-pro-php/tarball/master | tar xzv
```

#### Installing from the zip

[Click here](https://github.com/gocardless/gocardless-pro-php/zipball/master)
to download the zip file.

#### Installing with Composer

Add this repository to the contents of your `composer.json`:

```javascript
{
    "require": {
        "gocardless/gocardless-pro-php": "0.0.3"
    }
}
```

## Usage Examples

- Where a request returns a single resource, the client will return an response object with getters matching the resource's attributes and an attached raw response, retrivable with the `response()` method.
- Where a request returns multiple resources, the client will return a read-only `ListResponse` object with a method `records()` to return the retrieved records as an array.
- In case of non-JSON responses (PDFs, etc.), the library will return the raw response.
- To access data elements, use getter methods (as opposed to properties)
matching the keys in the JSON response - see the [GoCardless Pro API Docs](https://developer.gocardless.com/pro/) for details.

### Client Initialisation

```php
$client = new \GoCardlessPro\Client(array(
  'access_token' => 'YOUR API TOKEN',
  'environment'  => \GoCardlessPro\Environment::SANDBOX
));
```

The `api_key` and `api_secret` can be found under the "Organisation" tab in your GoCardless dashboard.

The environment can either be `\GoCardlessPro\Environment::SANDBOX` or `\GoCardlessPro\Environment::PRODUCTION`, depending on whether you want to use the sandbox or production API.

From the client object, resource objects can be accessed for each type of resource which can then be used to fetch or manipulate the resource's members. The available resources can be found in the [PHP library docs](http://gocardless.github.io/gocardless-pro-php/classes/GoCardless.Client.html).

### GET requests

Simple requests can be made like this, returning an iterable `ListResponse`:

```php
$client->resource()->list();
```

In the above example, replace `resource()` with the name of a resource (for example `customers()` to fetch a list of your customers) which returns a resource object.

If you need to pass any options, the last argument (or only argument, whether there are no requried options) to `list()` is an array of options:

```
$resources = $client->resource()->list(array('limit' => 400));
echo count($resources->records());
foreach ($resources->records() as $resource) {
  echo $resource->property_name();
}
```

Where URL parameters are required, the method signature will include those required arguments:

```
$customer = $client->customers()->get('CUXXXX');
echo $customer->given_name();

```

### POST/PUT Requests

Resource objects also have `create()` and `update()` methods for manipulating the resource's members. Provide a body for your request by passing it in as the first argument.
**You do not need to add the enclosing key.**

```php
try {
    $client->customer()->create(array(
        "invalid_name" => "Pete",
    ));
} catch (\GoCardlessPro\Core\Error\GoCardlessError $e) {
  // Server validation failed / record couldn't be created.
  echo $e->documentation_url();
  echo count($e->errors());
  // => $e is an ValidationFailedError.
} catch (\GoCardlessPro\Core\Error\HttpError $e) {
  echo $e;
}
```

This returns a response object representing the newly-created resource.

As with GET requests, if URL parameters are required, they come first:

```php
$client->resource()->update('RSIDXXXXX', array('key' => 'value'));
```

### Handling failures

When the API returns an error, the library will return a `\GoCardlessPro\Core\Error\GoCardlessError`-based error - this may be a `GoCardlessError` or one of its subclasses, `InvalidApiUsageError`, `InvalidStateError`, and `ValidationFailedError` if appropriate.

You can access the raw API error (unenveloped) via the `error()` method on the returned error, and a list of all the errors via the `errors()` method. By default the error's message will contain the error message from the API, plus a link to the documentation if available.

If the error is an HTTP transport layer error (e.g. cannot connect, empty response from server, etc.), the client will throw an `HttpError` based on the Curl error.

## Supporting PHP < 5.3.3

This client library only supports PHP >= 5.3.3 out of the box due to its extensive
use of OOP operators and namespaces.

## Contributing

This client is auto-generated. If there's a bug it's likely with the
[Crank](https://github.com/gocardless/crank) template or Crank itself. Bugs should be reported on those repositories.
