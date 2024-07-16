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
        ])->postalCodeSearchJSONFromPostCode(6600);
```


```php
     setCountryCode(string $countryCode): static;
    
     setPostalCode(int $value): static;

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
     searchJSON(string $country): JsonResponse|array|Collection;

     postalCodeSearchJSONFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;

     postalCodeSearchJSONFromName(string $name, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;

     findNearbyPostalCodes(int $lat, int $lng): JsonResponse|array|Collection;

     postalCodeCountryInfo(): JsonResponse|array|Collection;

     findNearbyJSON(int $lat, int $lng): JsonResponse|array|Collection;

```

## Response

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
