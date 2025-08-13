<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests\PointForecast\WeatherModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\AromeModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\CamsModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\GFSModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\IconEUModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamAlaskaModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamConusModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamHawaiiModel;
use Lsv\Windy\PointForecast\WeatherModels\WeatherModels;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class WeatherModelsTest extends TestCase
{
    #[TestWith([WeatherModels::Arome, 'arome', AromeModel::class])]
    #[TestWith([WeatherModels::GFS, 'gfs', GFSModel::class])]
    #[TestWith([WeatherModels::IconEU, 'iconEu', IconEUModel::class])]
    #[TestWith([WeatherModels::namConus, 'namConus', NamConusModel::class])]
    #[TestWith([WeatherModels::namHawaii, 'namHawaii', NamHawaiiModel::class])]
    #[TestWith([WeatherModels::namAlaska, 'namAlaska', NamAlaskaModel::class])]
    #[TestWith([WeatherModels::cams, 'cams', CamsModel::class])]
    public function testGetCorrectModel(WeatherModels $enum, string $expectedValue, string $expectedClassString): void
    {
        self::assertSame($expectedValue, $enum->value);
        self::assertSame($expectedClassString, $enum->getModel());
    }
}
