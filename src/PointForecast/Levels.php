<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast;

enum Levels: string
{
    case surface = 'surface';
    case h1000 = '1000h';
    case h950 = '950h';
    case h925 = '925h';
    case h900 = '900h';
    case h850 = '850h';
    case h800 = '800h';
    case h700 = '700h';
    case h600 = '600h';
    case h500 = '500h';
    case h400 = '400h';
    case h300 = '300h';
    case h200 = '200h';
    case h150 = '150h';

    /**
     * @return self[]
     */
    public static function default(): array
    {
        return [self::surface];
    }
}
