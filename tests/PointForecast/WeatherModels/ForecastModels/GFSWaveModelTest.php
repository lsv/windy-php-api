<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\GFSWaveModel;
use Lsv\Windy\PointForecast\WeatherParameter;
use PHPUnit\Framework\TestCase;

class GFSWaveModelTest extends TestCase
{
    public function testGetCorrectWeatherParameters(): void
    {
        $model = new GFSWaveModel();
        self::assertSame([
            WeatherParameter::waves,
            WeatherParameter::windWaves,
            WeatherParameter::swell1,
            WeatherParameter::swell2,
        ], $model->getAcceptedParameters());
    }
}
