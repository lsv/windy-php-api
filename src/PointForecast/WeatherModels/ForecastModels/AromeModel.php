<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModel;
use Lsv\Windy\PointForecast\WeatherParameter;

final readonly class AromeModel extends AbstractWeatherModel implements ForecastModel
{
    /**
     * @return WeatherParameter[]
     */
    public function getAcceptedParameters(): array
    {
        /** @var WeatherParameter[] $filtered */
        $filtered = array_filter(
            parent::getAcceptedParameters(),
            static fn (WeatherParameter $parameter) => !in_array(
                $parameter,
                [
                    WeatherParameter::snowPrecip,
                    WeatherParameter::gh,
                    WeatherParameter::pressure,
                ],
                true
            )
        );

        return array_values($filtered);
    }
}
