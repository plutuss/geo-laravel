# Laravel GeoNames API launch material

## GitHub repository metadata

**Description**

GeoNames API client for Laravel. Find places and postal codes, reverse geocode coordinates, and look up countries and time zones.

**Website**

[Packagist package page](https://packagist.org/packages/plutuss/laravel-geonames-api)

**Topics**

`laravel` `php` `geonames` `geocoding` `reverse-geocoding` `geolocation` `postal-codes` `timezone` `location-search`

## Release notes draft

**Title**

Laravel GeoNames API adds time-zone, country, and place lookups

This release adds time-zone lookup, country details, nearby populated places, lookup by GeoNames ID, and postal-code lookup.

- Query options apply to one request. An explicit country takes precedence over the configured default.
- Reverse geocoding accepts decimal coordinates. String postal codes preserve leading zeros and letters.
- Requests use HTTPS by default with the bundled configuration. HTTP and GeoNames API failures are surfaced as exceptions.

If you previously reused a fluent filter across calls, set it on each call or use the configured default country where supported. Update custom implementations of `GeoNameServiceInterface` for the new methods and signatures.

## Announcement draft

**Title**

Add postal-code lookup and local time zones to Laravel

I maintain an open-source Laravel client for GeoNames. It can suggest a city from a postal code in an address form or look up the local time zone for a page with coordinates. Install it with `composer require plutuss/laravel-geonames-api` and configure a GeoNames username to get started.

[Quick start on GitHub](https://github.com/plutuss/geo-laravel#quick-start) · [Install on Packagist](https://packagist.org/packages/plutuss/laravel-geonames-api)

## Publication checklist

1. Run `composer test` and try the quick-start examples against GeoNames with an enabled account.
2. Add the description, website, and topics to GitHub's About section.
3. Create a version tag and a GitHub release for the commit containing the code and docs. Check that Packagist lists that version and that the install command resolves to it.
4. Share the announcement with a short code example in a Laravel community that allows package announcements.
