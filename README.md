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
 composer require plutuss/laravel-geonames-api
```

```shell
php artisan vendor:publish --provider="Plutuss\GeoNames\Providers\GeoNamesServiceProvider"
```

```dotenv
#  .env
GEO_NAMES_USERNAME=user_name
```
Publishing the config is optional. Set `GEO_NAMES_USERNAME` before making requests.

## Use Facade GeoName

```php

        $response = GeoName::postalCodeSearchJSONFromName('city_name');

        $response = GeoName::setPostalCode(6600)
            ->setCountryCode('CH')
            ->postalCodeSearchJSONFromName('city_name');
            
          // OR
      
        $response = GeoName::setOption([
            'country' => 'CH',
        ])->postalCodeSearchJSONFromName('city_name');
```

```php
        $response = GeoName::postalCodeSearchJSONFromPostCode(6600);

        $response = GeoName::setCountryCode('CH')
            ->postalCodeSearchJSONFromPostCode(6600);
            
          // OR

        $response = GeoName::setOption([
            'country' => 'CH',
        ])->postalCodeSearchJSONFromPostCode('6600');

        $response = GeoName::postalCodeSearchJSONFromPostCode('01067');
        $response = GeoName::findNearbyJSON(51.0504, 13.7373);
```


```php
     setCountryCode(string $countryCode): static;
    
     setPostalCode(string|int $value): static;

     setPostalCodeStartsWith(string $value): static;
 
     setPlaceName(string $value): static;

     setPlaceNameStartsWith(string $value): static;

     setCountry(string $value): static;

     setCountryBias(string $value): static;

     setMaxRows(int $value): static;
  
     setStyle(string $value): static;

     setOperator(string $value): static;

     setCharset(string $value): static;

     setIsReduced(bool $value): static;
   
     setEast(float $value): static;
   
     setWest(float $value): static;

     setNorth(float $value): static;

     setSouth(float $value): static;
 
     setLatitude(string $value): static;

     setLongitude(string $value): static;
 
     setRadius(int $value): static;
```

```php
     setOption(array $params): static;
```

```php
     searchJSON(?string $country = null): JsonResponse|array|Collection;

     postalCodeSearchJSONFromPostCode(string|int $postalCode, ?int $radius = null, ?int $maxRows = null): JsonResponse|array|Collection;

     postalCodeSearchJSONFromName(string $name, ?int $radius = null, ?int $maxRows = null): JsonResponse|array|Collection;

     findNearbyPostalCodes(float $lat, float $lng): JsonResponse|array|Collection;

     getCountryCodeFromCoordinates(float $lat, float $lng): JsonResponse|array|Collection;

     postalCodeCountryInfo(): JsonResponse|array|Collection;

     findNearbyJSON(float $lat, float $lng): JsonResponse|array|Collection;

```

Options set through the facade apply to the next request and are cleared even if it fails.
Method arguments take precedence over fluent options, which take precedence over configuration defaults.
Postal searches default to a radius of 5 and a maximum of 10 rows.

## Response

An empty result is returned in the configured format. HTTP failures raise Laravel's HTTP client exception.
GeoNames errors and malformed responses raise `UnexpectedValueException`.

```php

     latitude(): mixed;

     getCollectionData(): Collection;

     getArrayData(): array;

     longitude(): mixed;

     placeName(): mixed;

     postalCode(): mixed;

     countryCode(): mixed;

     region(): mixed;

     land(): mixed;

    // The getNestedValue() method retrieves a value
    // from a deeply nested array using "dot" notation
    // $response->getNestedValue('key.array')
     getNestedValue($path, $default = null): mixed;
```
