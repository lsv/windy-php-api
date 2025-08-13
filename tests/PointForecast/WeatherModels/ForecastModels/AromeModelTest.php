<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\AromeModel;
use Lsv\Windy\PointForecast\WeatherParameter;
use PHPUnit\Framework\TestCase;

class AromeModelTest extends TestCase
{
    public function testGetCorrectWeatherParameters(): void
    {
        $model = new AromeModel();
        self::assertSame([
            WeatherParameter::temp,
            WeatherParameter::dewpoint,
            WeatherParameter::precip,
            WeatherParameter::convPrecip,
            WeatherParameter::wind,
            WeatherParameter::windGust,
            WeatherParameter::cape,
            WeatherParameter::ptype,
            WeatherParameter::lclouds,
            WeatherParameter::mclouds,
            WeatherParameter::hclouds,
            WeatherParameter::rh,
        ], $model->getAcceptedParameters());
    }
}
