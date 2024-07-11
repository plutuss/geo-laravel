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
        $response = GeoName::setPostalCode(6600)
            ->setCountryCode('AT')
            ->searchJSON('city_name');
            
      // OR
      
        $response = GeoName::setOption([
            'postalcode' => 6600,
            'country' => 'AT',
        ])->searchJSON('city_name');
```


```php
    public function setCountryCode(string $countryCode): static;
    
    public function setPostalCode(int $value): static;

    public function setPostalCodeStartsWith(string $value): static;
 
    public function setPlaceName(string $value): static;

    public function setPlaceNameStartsWith(string $value): static;

    public function setCountry(string $value): static;

    public function setCountryBias(string $value): static;

    public function setMaxRows(int $value): static;
  
    public function setStyle(string $value): static;

    public function setOperator(string $value): static;

    public function setCharset(string $value): static;

    public function setIsReduced(bool $value): static;
   
    public function setEast(float $value): static;
   
    public function setWest(float $value): static;

    public function setNorth(float $value): static;

    public function setSouth(float $value): static;
 
    public function setLatitude(string $value): static;

    public function setLongitude(string $value): static;
 
    public function setRadius(int $value): static;
```

```php
    public function setOption(array $params): static;
```

```php
    public function searchJSON(string $country): JsonResponse|array|Collection;

    public function postalCodeSearchJSONFromPostCode(int $postalCode, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;

    public function postalCodeSearchJSONFromName(string $name, int $radius = 5, int $maxRows = 10): JsonResponse|array|Collection;

    public function findNearbyPostalCodes(int $lat, int $lng): JsonResponse|array|Collection;

    public function postalCodeCountryInfo(): JsonResponse|array|Collection;

    public function findNearbyJSON(int $lat, int $lng): JsonResponse|array|Collection;

```
