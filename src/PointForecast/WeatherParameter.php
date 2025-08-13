<?php

declare(strict_types=1);
/** @noinspection SpellCheckingInspection */

namespace Lsv\Windy\PointForecast;

enum WeatherParameter: string
{
    /**
     * Air temperature.
     */
    case temp = 'temp';

    /**
     * The temperature of dew point, i.e., at which temperature the air reaches 100% humidity.
     */
    case dewpoint = 'dewpoint';

    /**
     * The overall accumulation of all precipitations (water column) for the preceding 3 hours, including snow precipitation and convection precipitation.
     */
    case precip = 'precip';

    /**
     * The overall snowfall (water column) for the preceding 3 hours.
     */
    case snowPrecip = 'snowPrecip';

    /**
     * The overall precipitation caused by convection (water column) for the preceding 3 hours.
     */
    case convPrecip = 'convPrecip';

    /**
     * Wind speed and direction.
     */
    case wind = 'wind';

    /**
     * The speed of wind at gusts.
     */
    case windGust = 'windGust';

    /**
     * Convective available potential energy.
     */
    case cape = 'cape';

    /**
     * Precipitation type.
     */
    case ptype = 'ptype';

    /**
     * Low clouds at levels with air pressure above 800 hPa.
     */
    case lclouds = 'lclouds';

    /**
     * Medium clouds at levels with air pressure between 450 hPa and 800 hPa.
     */
    case mclouds = 'mclouds';

    /**
     * High clouds at levels with air pressure below 450 hPa.
     */
    case hclouds = 'hclouds';

    /**
     * Relative humidity of air.
     */
    case rh = 'rh';

    /**
     * Geopotential height.
     */
    case gh = 'gh';

    /**
     * Air pressure.
     */
    case pressure = 'pressure';

    /**
     * The waves' height, period, and direction.
     */
    case waves = 'waves';

    /**
     * The wind waves' height, period, and direction.
     * Wind waves occur on the free surface of water bodies due to local winds.
     */
    case windWaves = 'windWaves';

    /**
     * The height, period, and direction of the waves swell.
     * Swells are created by winds in another area and are not locally generated.
     */
    case swell1 = 'swell1';

    /**
     * The height, period, and direction of the waves' swell. Similar to swell1, but the waves are of smaller sizes and come from a different area.
     */
    case swell2 = 'swell2';

    /**
     * Sulfur dioxide concentration, released naturally by volcanic activity or as a by-product of burning fossil fuels contaminated with sulfur compounds.
     */
    case so2sm = 'so2sm';

    /**
     * Dust particles in the atmosphere from sources such as soil, weather events, volcanic eruptions, and air pollution.
     */
    case dustsm = 'dustsm';

    /**
     * The level of carbon monoxide concentration in the troposphere.
     */
    case cosc = 'cosc';
}
