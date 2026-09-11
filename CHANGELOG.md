<!-- This file is generated, please add to it using `knope document-change` in the client-library-templates repo -->
# Changelog

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
