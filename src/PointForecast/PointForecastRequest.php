<?php

declare(strict_types=1);

namespace Lsv\Windy\PointForecast;

use Lsv\Windy\PointForecast\Response\Time;
use Lsv\Windy\PointForecast\Response\Value;
use Lsv\Windy\PointForecast\WeatherModels\WeatherModels;
use Lsv\Windy\RequestInterface;
use Lsv\Windy\Shared\Point;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[Assert\Callback(callback: [self::class, 'validate'])]
readonly class PointForecastRequest implements RequestInterface
{
    /**
     * @param WeatherParameter[]|null $weatherParameters
     * @param Levels[]|null           $levels
     */
    public function __construct(
        public Point $point,
        public WeatherModels $model,
        public ?array $weatherParameters = null,
        public ?array $levels = null,
    ) {
    }

    /**
     * @param self $request
     */
    public static function validate(RequestInterface $request, ExecutionContextInterface $context): void
    {
        if ($request->weatherParameters) {
            $model = $request->model->getModel();
            foreach ($request->weatherParameters as $parameter) {
                /* @phpstan-ignore-next-line as the instance is only checked by phpdoc and not a real generic we will ignore phpstan here */
                if (!$parameter instanceof WeatherParameter) {
                    $context
                        ->buildViolation('Parameter %parameter% is not a valid parameter')
                        ->setParameter('%parameter%', $parameter)
                        ->atPath('parameters')
                        ->addViolation();
                    continue;
                }

                if (!\in_array($parameter, new $model()->getAcceptedParameters(), true)) {
                    $context
                        ->buildViolation('Parameter "%parameter%" is not part of the model "%model%"')
                        ->setParameter('%parameter%', $parameter->value)
                        ->setParameter('%model%', $request->model->getModel())
                        ->atPath('parameters')
                        ->addViolation();
                }
            }
        }

        if ($request->levels) {
            foreach ($request->levels as $level) {
                /* @phpstan-ignore-next-line as the instance is only checked by phpdoc and not a real generic we will ignore phpstan here */
                if (!$level instanceof Levels) {
                    $context
                        ->buildViolation('Level "%level%" is not a valid level')
                        ->setParameter('%level%', $level)
                        ->atPath('levels')
                        ->addViolation();
                }
            }
        }
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function getHttpBody(): array
    {
        if (!$parameters = $this->weatherParameters) {
            $model = $this->model->getModel();
            $parameters = new $model()->getAcceptedParameters();
        }

        if (!$levels = $this->levels) {
            $levels = Levels::default();
        }

        return [
            'lat' => $this->point->latitude,
            'lon' => $this->point->longitude,
            'model' => $this->model->value,
            'parameters' => array_values(array_map(static fn (WeatherParameter $parameter) => $parameter->value, $parameters)),
            'levels' => array_values(array_map(static fn (Levels $levels) => $levels->value, $levels)),
        ];
    }

    public function getEndpoint(): string
    {
        return '/api/point-forecast/v2';
    }

    /**
     * @return Time[]
     */
    public function parseResponse(ResponseInterface $response): array
    {
        $times = [];
        /** @var array{ts: list<int>, units: array<string, string|null>, ...<string, list<int|float>>} $data */
        $data = (array) json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        /** @var string[] $columns */
        $columns = array_filter(array_keys($data), static fn ($key) => !\in_array($key, ['ts', 'units', 'warning'], true));

        foreach ($data['ts'] as $index => $time) {
            $values = [];
            foreach ($columns as $column) {
                if (null === $data['units'][$column]) {
                    continue;
                }

                $values[] = new Value($column, $data['units'][$column], (float) $data[$column][$index]);
            }

            $times[] = new Time(new \DateTimeImmutable()->setTimestamp($time), $values);
        }

        return $times;
    }
}
