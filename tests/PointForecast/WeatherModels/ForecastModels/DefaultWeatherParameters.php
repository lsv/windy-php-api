<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModel;
use Lsv\Windy\PointForecast\WeatherParameter;

trait DefaultWeatherParameters
{
    abstract public function getModel(): ForecastModel;

    public function testGetCorrectWeatherParameters(): void
    {
        $model = $this->getModel();
        self::assertSame([
            WeatherParameter::temp,
            WeatherParameter::dewpoint,
            WeatherParameter::precip,
            WeatherParameter::convPrecip,
            WeatherParameter::snowPrecip,
            WeatherParameter::wind,
            WeatherParameter::windGust,
            WeatherParameter::cape,
            WeatherParameter::ptype,
            WeatherParameter::lclouds,
            WeatherParameter::mclouds,
            WeatherParameter::hclouds,
            WeatherParameter::rh,
            WeatherParameter::gh,
            WeatherParameter::pressure,
        ], $model->getAcceptedParameters());
    }
}
