# PHP Client for GoCardless Enterprise API

- [PHP Doc API Doc](http://gocardless.github.io/gocardless-pro-php/)
- [GoCardless Pro API Docs](https://developer.gocardless.com/pro/)
- [Composer Package](https://packagist.org/packages/gocardless/gocardless-pro-php)

### Installation

The files you need to use the GoCardless API are in the `/lib` folder, however, you should use the loader.php file in the lib folder to load the library.
To load the library, you only need to require the `lib/loader.php` folder, if you're using composer, you should use the composer loader for this library.

#### Install from source

```console
$ git clone git://github.com/gocardless/gocardless-pro-php.git
```

#### Installing from the tarball

```console
$ curl -L https://github.com/gocardless/gocardless-pro-php/tarball/master | tar xzv
```

#### Download the Zip

[Click here](https://github.com/gocardless/gocardless-pro-php/zipball/master)
to download the zip file.

#### Installing with Composer

Add this beta repo to the contents of your composer.json:

```javascript
{
    "require": {
        "gocardless/gocardless-pro-php": "0.0.2"
    }
}
```

## Usage Examples

- In the case of singular responses, Crank will return you an response object with getters matching the json descriptions and an attached response().
- In the case of list responses, Crank returns an list response object that is read-only. Raw array data can be retrieved from the items() function of the object.
- In the case of non JSON responses, Crank will return the raw response (PDFs etc.) (through resource->response()->raw())
- To access data elements, use getter methods with underscores (given_name) matching the JSON response for consistency. 

### Client Initialisation
```php
$client = new \GoCardless\Client(array(
  'api_key' => 'YOUR API KEY',
  'api_secret' => 'YOUR API SECRET',
  'environment' => \GoCardless\Environment::SANDBOX
));
```
The api_key and api_secret can be found under the organisation tab, the environment can either be `\GoCardless\Environment::SANDBOX` or `\GoCardless\Environment::PRODUCTION`.

Given the client object, resource objects can be accessed then methods on each resource can be called to either fetch or manipulate the resource's members.

The resource objects and returned services can be found in the [PHP API Doc for Client](http://gocardless.github.io/gocardless-pro-php/classes/GoCardless.Client.html).

### GET requests

Simple requests can be made like this:

```php
$client->resource()->list();
```
returning an iteratable ListResponse.


If you need to pass any options, the last (or in the absence of URL params, the only) argument is an options hash. You can use this to pass parameters like this:
```
$resources = $client->resource()->list(array('limit' => 400));
echo count($resources);
foreach ($resources as $resource) {
  $resource->property_name();
}
```

In the case where url parameters are needed, the method signature will contain required arguments:

```
$customer = $client->customers()->show('CUXXXX');
echo $customer->given_name();

```

As with list, the last argument can be an options hash:

```
$resource = $client->resource()->show('IDXXXX', array('limit' => 200));
echo $resource;
```

### POST/PUT Requests
If your request needs a body, you can add this by passing it in as the first argument.
**Note**, you do not need to add the enclosing key!

```
try {
    $client->customer()->create(array(
        "invalid_name" => "Pete",
    ));
} catch (\GoCardless\Core\Error\GoCardlessError $e) {
  // Server validation failed / record couldn't be created.
  echo $e->documentation_url();
  echo count($e->errors());
  // => $e is an ValidationFailedError.
} catch (\GoCardless\Core\Error\HttpError $e) {
  echo $e;
}
```
This returns a response object as the new created resource

As with GET requests, if url params are required they come first.

```
$client->resource()->update('RSIDXXXXX', array('key' => 'value'));
```

### Handling failures

When an API returns an error, Crank will return an `GoCardlessError`.

Assuming the error response form the server is in JSON format, like:

```
{
  "error": {
    "documentation_url": "https://developer.gocardless.com/enterprise#validation_failed",
    "message": "Validation failed",
    "type": "validation_failed",
    "code": 422,
    "request_id": "dd50eaaf-8213-48fe-90d6-5466872efbc4",
    "errors": [
      {
        "message": "must be a number",
        "field": "sort_code"
      }, {
        "message": "is the wrong length (should be 8 characters)",
        "field": "sort_code"
      }
    ]
  }
}
```

Crank will return an `\GoCardless\Core\Error\GoCardlessError`-based error. The possible errors vary on the exception internally but are `InvalidApiUsageError`, `InvalidStateError`, and `ValidationFailedError`, all other errors use the `GoCardlessError` class. If the error is an http transport layer error (cannot connect, empty response from server, etc.), the client will throw an `HttpError` based off of the php_curl errors. You can access the raw hash (unenveloped) via the `->error()` method, and a list of all the errors via the `->allErrors()` method. By default the error message will contain the error's message and a link to the documentation if it exists.

In order to access an error, use getters instead of properties just as in resources: $error->errors()[0]->message();

## Supporting PHP < 5.3.3
Crank only supports PHP >= 5.3.3 out of the box due to its extensive
use of OOP operators and namespaces.

## Contributing

This client is auto-generated. If there's a bug it's likely with the
[Crank](https://github.com/gocardless/crank) template or Crank itself.

Bugs should be reports on those respective repositories.
