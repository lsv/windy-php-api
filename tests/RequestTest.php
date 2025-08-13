<?php

declare(strict_types=1);

namespace Lsv\Windy\Tests;

use Lsv\Windy\PointForecast\Levels;
use Lsv\Windy\PointForecast\PointForecastRequest;
use Lsv\Windy\PointForecast\Response\Time;
use Lsv\Windy\PointForecast\WeatherModels\WeatherModels;
use Lsv\Windy\PointForecast\WeatherParameter;
use Lsv\Windy\Request;
use Lsv\Windy\Shared\Point;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

class RequestTest extends TestCase
{
    private static array $data = [
        'ts' => [
            1755054000000,
            1755064800000,
            1755075600000,
            1755086400000,
            1755097200000,
            1755108000000,
            1755118800000,
            1755129600000,
            1755140400000,
            1755151200000,
            1755162000000,
            1755172800000,
            1755183600000,
            1755194400000,
        ],
        'units' => [
            'temp-surface' => 'K',
            'dewpoint-surface' => 'K',
            'past3hprecip-surface' => 'm',
            'past3hconvprecip-surface' => 'm',
            'wind_u-surface' => 'm*s-1',
            'wind_v-surface' => 'm*s-1',
            'gust-surface' => 'm*s-1',
            'cape-surface' => 'J*kg-1',
            'ptype-surface' => null,
            'lclouds-surface' => '%',
            'mclouds-surface' => '%',
            'hclouds-surface' => '%',
            'rh-surface' => '%',
        ],
        'temp-surface' => [-18.7, -10.5, 42.1, -15.3, 9.8, 35.4, 12.7, 25.6, -3.4, 48.9, 36.6, -8.2, 20.3, -12.5],
        'dewpoint-surface' => [14.7, 2.1, -7.9, 32.8, -12.5, 9.0, 24.7, -5.8, 7.3, 18.9, -3.6, 40.7, -10.2, 21.4],
        'past3hprecip-surface' => [30.4, -19.7, 6.8, -6.5, 1.9, 28.2, 10.3, -17.9, 22.4, 31.5, -14.8, 40.2, 47.6, -8.4],
        'past3hconvprecip-surface' => [
            12.3,
            45.6,
            10.8,
            -18.4,
            22.5,
            16.7,
            -9.3,
            8.4,
            21.4,
            -7.6,
            30.1,
            -16.9,
            48.6,
            4.2,
        ],
        'wind_u-surface' => [23.2, -14.7, 31.6, 17.5, 22.8, 29.0, -3.5, 12.9, 24.3, -2.8, 44.6, -19.3, 29.5, 6.7],
        'wind_v-surface' => [18.6, 3.7, 29.4, 11.3, -17.8, 14.6, 28.3, -6.4, 35.1, 9.5, -13.7, 43.8, 12.4, 21.5],
        'gust-surface' => [15.8, 32.7, 9.2, 27.3, -5.8, 19.0, 44.5, 6.8, 34.9, -11.9, 13.2, 36.2, -7.7, 4.9],
        'cape-surface' => [42.3, 21.5, -18.7, 33.1, 48.6, 8.6, 10.5, 23.8, -4.9, 37.6, -13.3, 19.8, 25.4, 6.2],
        'ptype-surface' => [-14.5, 28.9, 38.7, 16.3, -6.7, 25.1, -18.8, 39.5, 15.7, 11.9, -20.0, 24.6, 33.8, -11.4],
        'lclouds-surface' => [29.8, 19.7, 14.6, 8.2, 39.1, -15.2, 26.5, -2.9, 37.3, -16.4, 22.5, 15.6, 44.8, -18.1],
        'mclouds-surface' => [27.9, 13.5, -14.8, 45.9, 31.4, 12.7, 8.9, 25.3, 40.8, 11.6, -3.7, 48.7, 36.3, -8.5],
        'hclouds-surface' => [30.2, -10.4, 8.4, -18.4, 38.0, 28.3, -7.8, 44.5, 26.6, 15.8, 19.7, -16.9, 24.9, -11.6],
        'rh-surface' => [48.3, 17.2, 9.3, 41.8, -11.5, 35.7, 15.9, -6.3, 21.3, 46.5, -4.8, 33.2, 30.0, 10.4],
    ];

    private MockHttpClient $mockClient;
    private Request $service;
    private Psr17Factory $responseFactory;

    protected function setUp(): void
    {
        $this->mockClient = new MockHttpClient();
        $this->responseFactory = new Psr17Factory();
        $client = new Psr18Client($this->mockClient, $this->responseFactory, $this->responseFactory);
        $this->service = new Request(
            'api-key',
            $client,
        );
    }

    public function testCanMakeRequest(): void
    {
        $request = new PointForecastRequest(
            new Point(1.0, 2.0),
            WeatherModels::Arome,
        );

        $response = new JsonMockResponse(self::$data);
        $this->mockClient->setResponseFactory($response);

        $data = $this->service->request($request);

        // Request
        self::assertSame('POST', $response->getRequestMethod());
        self::assertSame('https://api.windy.com/api/point-forecast/v2', $response->getRequestUrl());
        $requestBody = \json_decode($response->getRequestOptions()['body'], true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('api-key', $requestBody['key']);
        self::assertSame(WeatherModels::Arome->value, $requestBody['model']);

        $model = WeatherModels::Arome->getModel();
        $params = \array_map(static fn (WeatherParameter $pm) => $pm->value, (new $model())->getAcceptedParameters());
        self::assertEmpty(array_diff($params, $requestBody['parameters']));

        $levels = Levels::default();
        $params = \array_map(static fn (Levels $lvl) => $lvl->value, $levels);
        self::assertEmpty(array_diff($params, $requestBody['levels']));

        // Response
        self::assertCount(14, $data);
        /** @var Time $time */
        $time = $data[0];
        self::assertSame('1755054000000', $time->time->format('U'));
        self::assertCount(12, $time->values);
        self::assertSame('temp-surface', $time->values[0]->name);
        self::assertSame('K', $time->values[0]->unit);
        self::assertSame(-18.7, $time->values[0]->value);
        self::assertSame('rh-surface', $time->values[11]->name);
        self::assertSame('%', $time->values[11]->unit);
        self::assertSame(48.3, $time->values[11]->value);
    }

    public function testNotAcceptedParameter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Parameter not-accepted-parameter is not a valid parameter');

        $request = new PointForecastRequest(
            new Point(1.0, 2.0),
            WeatherModels::Arome,
            ['not-accepted-parameter']
        );

        $this->service->request($request);
    }

    public function testParameterNotInModel(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Parameter "waves" is not part of the model "Lsv\Windy\PointForecast\WeatherModels\ForecastModels\AromeModel"');

        $request = new PointForecastRequest(
            new Point(1.0, 2.0),
            WeatherModels::Arome,
            [WeatherParameter::waves]
        );

        $this->service->request($request);
    }

    public function testLevelNotAValidParameter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Level "not-a-valid-level" is not a valid level');

        $request = new PointForecastRequest(
            new Point(1.0, 2.0),
            WeatherModels::Arome,
            levels: ['not-a-valid-level']
        );

        $this->service->request($request);
    }
}
