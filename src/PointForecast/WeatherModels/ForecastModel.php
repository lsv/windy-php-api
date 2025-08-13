<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\WeatherModels;

use Lsv\Windy\PointForecast\WeatherParameter;

interface ForecastModel
{
    /**
     * Get the accepted parameters for the model.
     *
     * @return WeatherParameter[]
     */
    public function getAcceptedParameters(): array;
}
