# Windy API Client

A library for interacting with the [Windy.com API](https://api.windy.com). This PHP client provides a streamlined way to request and handle weather forecast data from Windy's API.

## Features

- Easy integration with Windy.com API
- PSR compliant (HTTP Client, Request, Response, Logger)
- Supports Symfony Validator for request validation
- Includes utilities for working with point forecasts and weather models
- Fully tested with PHPUnit
- Automatic API request and response handling

## Requirements

- PHP 8.1 or higher
- A valid Windy API key
- Composer for dependency management

---

## Installation

Install the library via Composer:

```bash
composer require lsv/windy-api
```

---

## Usage

### Basic forecast request

```php
<?php

require 'vendor/autoload.php';

use Lsv\Windy\Request;
use Lsv\Windy\PointForecast\PointForecastRequest;
use Lsv\Windy\PointForecast\WeatherModels\WeatherModels;
use Lsv\Windy\Shared\Point;

// Your Windy API key
$apiKey = 'your_api_key_here';

// Create a new request instance
$request = new Request($apiKey);

// Create a new PointForecastRequest
$forecastRequest = new PointForecastRequest(
    point: new Point(latitude: 55.6761, longitude: 12.5683), // Example coordinates: Copenhagen, Denmark
    model: WeatherModels::AROME, // Multiple weather models are supported eg WeatherModels::IconEU, WeatherModels::GFS
    parameters: null, // Optional: Use default parameters accepted by the model multiple parameters are available eg. [WeatherParameter::temp, WeatherParameter::dewpoint]
    levels: null      // Optional: Use default levels [Levels::surface] is default, multiple levels are supported eg [Levels::surface, Levels::h1000]
);

// Send the request and get the response
try {
    $response = $request->request($forecastRequest);
    // $response is an array of Time[] objects
    // $response[0]->time - DateTimeInterface;
    // $response[0]->values - array of Value[] objects
    // $response[0]->values[0]->name - name of the value;
    // $response[0]->values[0]->unit - string - The value unit
    // $response[0]->values[0]->value - int|float - the value;
} catch (\Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## Todo
- ~~Point forecast~~
- Map forecast
- Webcams


## Development

### Code Quality

The project uses PHPStan and PHP CS Fixer for static analysis and coding standards. Run the following command to check and fix code quality:

```bash
composer fix
```

---

## License

This library is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.