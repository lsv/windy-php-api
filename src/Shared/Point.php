<?php

declare(strict_types=1);

namespace Lsv\Windy\Shared;

class Point
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
