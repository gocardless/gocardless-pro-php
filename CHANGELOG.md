<!-- This file is generated, please add to it using `knope document-change` in the client-library-templates repo -->
# Changelog

## 8.18.0 (2026-10-28)

### Features

#### Use Billing Requests instead of Redirect Flows and Payer Authorisations

Redirect Flows and Payer Authorisations are legacy APIs and cannot be used by new integrators. If you use `redirectFlows()` and `payerAuthorisations()`, migrate to [Billing Requests](https://developer.gocardless.com/api-reference/#billing-requests), which cover the same flows (and more) through a single API. The [integration planner](https://docs.gocardless.com/docs/collect-payments/integration-planner) is a good place to start.

The legacy methods are now marked as deprecated with PHPDoc `@deprecated` tags. Behaviour is unchanged. IDEs and static analysers that understand PHPDoc will flag these methods.

## 8.17.0 (2026-10-27)

### Features

#### Add `include` parameter to payments

Includes linked resources in the response. Use `customer` to embed customer details, or `mandate` to embed mandate details.

### Fixes

#### Correct `day_of_month` documentation for subscriptions and plans

For subscriptions and plans, values `1`-`31` or `-1` are accepted, not just `1`-`28`.

`1`-`28` applies to payout intervals, creditors and mandate caps.

## 8.16.0 (2026-10-26)

### Features

#### Time out requests after 60 seconds by default

The `timeout` client option already existed, but defaulted to `0`, which waits indefinitely, so a stalled connection could hang forever. It now defaults to 60 seconds. If you rely on requests taking longer than that, pass a larger `timeout`, or `0` to restore the old behaviour:

```php
$client = new \GoCardlessPro\Client([
  'access_token' => $access_token,
  'environment'  => \GoCardlessPro\Environment::SANDBOX,
  'timeout'      => 10
]);
```

Timed out requests are retried automatically before an `ApiConnectionException` is raised, so the total time before an error can exceed `timeout`. The `timeout` option is not applied if you supply your own `http_client`.

## 8.15.2 (2026-10-23)

### Fixes

#### Recommend upgrading PHP to fix critical vulnerabilities

The README now recommends always using the latest patch release of a supported PHP version.

PHP 8.5.12, 8.4.27, 8.3.36 and 8.2.35 fix two critical vulnerabilities that can allow unauthenticated remote code execution: [CVE-2026-109618](https://github.com/php/php-src/security/advisories/GHSA-w8hw-w9fx-j79w) and [CVE-2026-109619](https://github.com/php/php-src/security/advisories/GHSA-6wmf-4rv5-p3rp). These vulnerabilities are in PHP itself, not in this library. If you are running an earlier version of PHP, please upgrade as soon as possible. See the [PHP security advisory](https://www.php.net/archive/2026.php#2026-10-21-5) for more details.

## 8.15.1 (2026-10-13)

### Fixes

#### Make string response body handling more consistent

Error responses whose `error` is a plain string (eg HTML from Cloudflare), with a status other than 400, 401, 403 or 429 (for example a 404 or 500), previously raised `GoCardlessProException: Invalid error type` and lost the message from the response. They now raise `GoCardlessInternalException` with the message from the response, and `getType()` returns `gocardless` as it is an internal error.

## 8.15.0 (2026-10-12)

### Features

#### Add `include` parameter to mandates

Includes linked resources in the response. Use `customer` to embed customer details, or `bank_account` to embed bank account details.

## 8.14.2 (2026-10-07)

### Fixes

- Remove unused definitions from schema

## 8.14.1 (2026-10-06)

### Fixes

#### Fix Institutions include_disabled request param to a string enum

This field is only used in request parameters on GET requests. Parameters on
GET requests are querystrings and can only ever be strings.

Therefore any attempt was rejected with "One of your parameters was incorrectly
typed" - "\"true\" is not a boolean.".

This string enum "true" or "false" is our general pattern for parameters like this.

## 8.14.0 (2026-10-06)

### Features

#### Add previously undocumented fields to billing_request

Add `payment_request.retry_if_possible` - On failure, automatically retry payments using intelligent retries.
Add `actions.available_country_codes` - list of currencies the current mandate supports

## 8.13.0 (2026-10-06)

### Features

- Updates the public institutions API to allow merchants to provide the include_disabled query param and see institution status per feature

## 8.12.1 (2026-10-06)

### Fixes

#### Document `required` fields on several API resource responses

Several resource response schemas were missing `required` field lists,
even though the fields are always present in the actual response.
Added accurate `required` arrays (and fixed a few hardcoded docs
examples that predated them) for: `payment`, `bank_details_lookup`,
`billing_request_template`, `currency_exchange_rate`, `mandate_import`,
`mandate_import_entry`, `negative_balance_limit`, `payer_authorisation`,
`payout`, `payout_item`, `refund`, `scenario_simulator`,
`scheme_identifier`, `tax_rate`, `verification_detail` and `logo`.

This is a documentation-only change; API behaviour is unchanged.

## 8.12.0 (2026-10-06)

### Features

#### Reject request paths that would leave the configured base URL

The low-level request path was joined onto the configured base URL with a resolving
join, which follows a path the way a browser follows a link. An absolute URL
(`https://host/x`) or a scheme-relative one (`//host/x`) replaced the configured
origin outright while the Authorization header was still attached, so an application
that passed untrusted input as a path could send its API token to a host of someone
else's choosing.

A path that is not a relative reference is now rejected before the join. Paths
containing dot segments remain valid: they resolve against the base URL and cannot
leave its origin.

#### Reject URL parameters that could change which endpoint is addressed

A URL parameter is a single path segment — a resource identity — but the escaping
applied to one varied by language, and in Go, Node, PHP and .NET there was none at
all. A value carrying path syntax could move a request to an endpoint the caller
never asked for: `find("../mandates")` reached the mandates collection, and
`find("?limit=500")` injected a query parameter.

Escaping alone cannot fix this, because `.` and `..` are dot segments that a path
resolver strips whether or not they are encoded, and an empty value addresses the
collection rather than one resource. Values that could change which endpoint is
addressed are therefore rejected rather than escaped: `/`, `?`, `#`, control
characters, `.`, `..` and the empty string now raise an error instead of producing a
request that quietly 404s. Everything else is escaped as before.

No valid GoCardless resource identity contains any of these characters, so correct
code is unaffected. Ruby and Java previously encoded `/` as `%2F` and sent the
request; they now raise.

## 8.11.0 (2026-10-05)

### Features

- Fixed postal_code and country_code fields on Scheme Identifiers to correctly allow null values.

## 8.10.0 (2026-10-02)

### Features

- Fixed response_body_truncated, response_headers_content_truncated, and response_headers_count_truncated fields on Webhooks to correctly allow null values.

## 8.9.0 (2026-10-02)

### Features

- Fixed the email field in merchant_contact_details on Billing Request Flows to correctly allow null values.

## 8.8.1 (2026-10-02)

### Fixes

- Fixed the url field on Bank Authorisations to correctly allow null values.

## 8.8.0 (2026-10-01)

### Features

- Made account_number_ending nullable across all resources that reference this shared definition

## 8.7.0 (2026-10-01)

### Features

- Added `language` and `phone_number` properties to prefilled_customer in Billing Request Flows.

## 8.6.0 (2026-10-01)

### Features

#### Fixes to mandate property definitions

* Add missing `consent_parameters` properties: `id`, `scheme`, `currency`, `fixed_amount_per_payment`
* Make `max_amount_per_period`, `max_payments_per_period` and `end_date` nullable
* Add missing `period_alignment` to `period_alignment` enum

### Fixes

#### Fix `GET /institutions` documentation incorrectly listing `status` and `autocompletes_collect_bank_account` fields

These fields are only returned by `GET /billing_requests/{identity}/institutions`, not by the top-level `GET /institutions` endpoint. This is a documentation-only fix; API behaviour is unchanged.

## 8.5.6 (2026-10-01)

### Fixes

#### Correct supported type list for /customer_notifications/{id}/actions/handle

Only `payment_created`, `mandate_created` and `subscription_created` are supported for now, but the enum implied it was more event types.

The enum is unchanged to avoid breaking consumers dependent on the ordering.

## 8.5.5 (2026-09-30)

### Fixes

- Add missing bank_name property to payer_authorisation bank_account schema

## 8.5.4 (2026-09-30)

### Fixes

- Fix nullable metadata reference in billing_request list response schema

## 8.5.3 (2026-09-30)

### Fixes

#### Refine types for billing_request amount fields

The API and client libraries accept string or integer for amount-type fields.
We only emit those same fields as integer.
However, the schema incorrectly specified string or integer for the response as well as the request.

## 8.5.2 (2026-09-30)

### Fixes

- Prune unused definitions from the schema

## 8.5.1 (2026-09-29)

### Fixes

- Add missing institution properties to billing_request schema

## 8.5.0 (2026-09-29)

### Features

#### Add `payer_name_verification_result` to bank details lookups

Bank details lookups now return a `payer_name_verification_result` field when an `account_holder_name` is supplied and a payer name verification check is performed. It can be `full`, `close`, `cannot_perform_verification` or `null`

## 8.4.0 (2026-09-25)

### Features

#### Add `interval` param to `GET /reporting/metrics` for aggregating results by day, week, or month

You can now pass `interval` (`daily`, `weekly`, or `monthly`) when fetching metrics to have values aggregated over that period, instead of only receiving a single value for the full `start_date`/`end_date` range.

## 8.3.2 (2026-09-22)

### Fixes

- Fix example values for a small number of fields to comply with the schema

## 8.3.1 (2026-09-22)

### Fixes

- Fix schema definition/component names to avoid losing types in openapi schema

## 8.3.0 (2026-09-17)

### Features

- Add "reference" to Create Bank Account Holder Verification

## 8.2.3 (2026-09-16)

### Fixes

- Clean up docs and use a shared definition of event `include` and `resource_type` enums

## 8.2.2 (2026-09-14)

### Fixes

#### Fix nullable field declarations and missing properties across multiple resources

Adds `null` to type declarations for fields that legitimately return nil across redirect_flows, webhooks, scheme_identifiers, customer_bank_accounts, outbound_payments, and billing_request_with_actions. Also adds the missing `period_alignment` property to mandate consent_parameters.

## 8.2.1 (2026-09-14)

### Fixes

#### Add missing enum values to schema definitions

Adds `sepa_credit_transfer` and `sepa_instant_credit_transfer` to the complete scheme enum, adds hosted payment flow sources to the event source/type enum, and makes `creditor_type` nullable for legacy creditors.

## 8.2.0 (2026-09-11)

### Features

#### Use specific sub-endpoints URLs for create /instalment_schedules: with_schedule and with_dates

The two variants for creating an instalment_schedule were surfaced as separate functions. However, they both went to the same URL and endpoint on the backend.

This created some bugs in generating our openapi schema and therefore our API reference documentation.

Therefore, we've added specific URLs for each endpoint aliased to the original one: `POST /instalment_schedules/with_dates` or `POST /instalment_schedules/with_schedule`.

The existing POST /instalment_schedules endpoint is unchanged and will remain available for the foreseeable future.

Client libraries will now use the specific endpoint matching the method - if you are stubbing the HTTP call you may need to update those stubs.

## 8.1.5 (2026-09-09)

### Fixes

- Add remember_me to ui_components bootstrap endpoint

## 8.1.4 (2026-09-08)

### Fixes

#### Remove incorrect Pro/Enterprise restriction from mandate and customer bank account endpoints

The "Create a mandate", "Reinstate a mandate", and "Create a customer bank account" endpoints incorrectly stated they were restricted to GoCardless Pro and Enterprise accounts. Custom payment pages are available to any merchant — they are not package-restricted.

## 8.1.3 (2026-09-07)

### Fixes

- Update code samples to match change to integer types for amounts etc

## 8.1.2 (2026-09-04)

### Fixes

#### Define common titles for common types

The intention is to make it possible to define common types in generated code.
Instead of ~37 different currency enum types which are all equivalent, we could have one.

## 8.1.1 (2026-09-02)

### Fixes

- Fix typo in Mandate next_possible_standard_ach_charge_date description

## 8.1.0 (2026-09-01)

### Features

#### Add `app_connected_organisations` export type

Exports can now be created with `resource_type: app_connected_organisations`, allowing connected merchant details to be exported.

## 8.0.7 (2026-08-27)

### Fixes

- Fix typo in subscription status description

## 8.0.6 (2026-08-13)

### Fixes

- Fix typo in mandate_import_entry status description

## 8.0.5 (2026-08-13)

### Fixes

- Fix typo in mandate_import_entry status description

## 8.0.4 (2026-08-13)

### Fixes

- Fix typo in mandate_import_entry status description

## 8.0.3

Start of changelog tracking with Knope. See [GitHub releases](https://github.com/gocardless/gocardless-pro-php/releases) for the history of earlier versions.
