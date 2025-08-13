<?php

declare(strict_types=1);
/** @noinspection SpellCheckingInspection */

namespace Lsv\Windy\PointForecast\WeatherModels;

use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\AromeModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\CamsModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\GFSModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\GFSWaveModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\IconEUModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamAlaskaModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamConusModel;
use Lsv\Windy\PointForecast\WeatherModels\ForecastModels\NamHawaiiModel;

enum WeatherModels: string
{
    /**
     * Covers France and surrounding areas.
     */
    case Arome = 'arome';

    /**
     * Covers Europe and surrounding areas.
     */
    case IconEU = 'iconEu';

    /**
     * A global model.
     */
    case GFS = 'gfs';

    /**
     * A global model excluding Hudson Bay (partly), the Black Sea, the Caspian Sea, and most of the Arctic Ocean.
     */
    case GFSWave = 'gfsWave';

    /**
     * Covers the USA and surrounding areas (Canada, Mexico).
     */
    case namConus = 'namConus';

    /**
     * Covers Hawaii.
     */
    case namHawaii = 'namHawaii';

    /**
     * Covers Alaska and surrounding areas.
     */
    case namAlaska = 'namAlaska';

    /**
     * A global webcam model.
     */
    case cams = 'cams';

    /**
     * @return class-string<ForecastModel>
     */
    public function getModel(): string
    {
        return match ($this) {
            self::Arome => AromeModel::class,
            self::IconEU => IconEUModel::class,
            self::GFS => GFSModel::class,
            self::GFSWave => GFSWaveModel::class,
            self::namConus => NamConusModel::class,
            self::namHawaii => NamHawaiiModel::class,
            self::namAlaska => NamAlaskaModel::class,
            self::cams => CamsModel::class,
        };
    }
}
