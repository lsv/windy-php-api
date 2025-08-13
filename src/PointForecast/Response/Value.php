<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\Response;

final readonly class Value
{
    public function __construct(
        public string $name,
        public string $unit,
        public int|float $value,
    ) {
    }
}
