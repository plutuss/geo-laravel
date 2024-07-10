## Installed packages

## Laravel:

- [GitHub](https://github.com/plutuss/geo-laravel).

> [!NOTE]
> The Laravel Geonames API package provides an easy way to integrate the Geonames API into your Laravel application.
> This package enables developers to effortlessly interact with the Geonames API to retrieve geographic data such as
> cities, countries, coordinates, time zones, and other location-based information.

- Key Features

1. **Geonames API Requests**: Simple method to send requests and handle responses from the Geonames API.
2. **Support for Various Query Types**: Supports all major query types including name searches, reverse geocoding, and
   more.
3. **Configuration**: Easy setup of API credentials and other parameters through a configuration file.
4. **Laravel Compatibility**: Full integration with the Laravel ecosystem, including support for Service Providers and
   Facades.



```shell
 composer require plutuss/geo-names-laravel
```

```shell
php artisan vendor:publish --provider="Plutuss\GeoNames\Providers\GeoNamesServiceProvider"
```

```dotenv
#  .env
GEO_NAMES_USERNAME=user_name
```
