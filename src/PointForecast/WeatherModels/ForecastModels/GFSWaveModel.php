<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModel;
use Lsv\Windy\PointForecast\WeatherParameter;

final readonly class GFSWaveModel implements ForecastModel
{
    public function getAcceptedParameters(): array
    {
        return [
            WeatherParameter::waves,
            WeatherParameter::windWaves,
            WeatherParameter::swell1,
            WeatherParameter::swell2,
        ];
    }
}
