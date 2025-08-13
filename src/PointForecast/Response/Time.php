<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast\Response;

final readonly class Time
{
    /**
     * @param Value[] $values
     */
    public function __construct(
        public \DateTimeInterface $time,
        public array $values,
    ) {
    }
}
