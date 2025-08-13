<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels\ForecastModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamAlaskaModel;
use PHPUnit\Framework\TestCase;

class NamAlaskaModelTest extends TestCase
{
    use DefaultWeatherParameters;

    public function getModel(): ForecastModel
    {
        return new NamAlaskaModel();
    }
}
