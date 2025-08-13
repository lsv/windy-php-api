<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamConusModel;
use PHPUnit\Framework\TestCase;

class NamConusModelTest extends TestCase
{
    use DefaultWeatherParameters;

    public function getModel(): ForecastModel
    {
        return new NamConusModel();
    }
}
