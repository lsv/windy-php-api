<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\CamsModel;
use Lsv\Windy\PointForecast\WeatherParameter;
use PHPUnit\Framework\TestCase;

class CamsModelTest extends TestCase
{
    public function testGetCorrectWeatherParameters(): void
    {
        $model = new CamsModel();
        self::assertSame([
            WeatherParameter::so2sm,
            WeatherParameter::dustsm,
            WeatherParameter::cosc,
        ], $model->getAcceptedParameters());
    }
}
