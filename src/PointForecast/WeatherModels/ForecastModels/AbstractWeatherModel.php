<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherParameter;

abstract readonly class AbstractWeatherModel
{
    /**
     * @return WeatherParameter[]
     */
    public function getAcceptedParameters(): array
    {
        return [
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
        ];
    }
}
