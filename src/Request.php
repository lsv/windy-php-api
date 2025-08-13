<?php

declare(strict_types=1);

namespace Lsv\Windy;

use Http\Discovery\Psr17Factory;
use Http\Discovery\Psr18Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\Validator\Validation;

final class Request
{
    private StreamFactoryInterface&RequestFactoryInterface&UriFactoryInterface $httpRequest;
    private ClientInterface $httpClient;

    public function __construct(
        #[\SensitiveParameter]
        private readonly string $apiKey,
        private readonly ?ClientInterface $httpClientFactory = null,
        private readonly ?Psr17Factory $httpRequestFactory = null,
    ) {
        $this->httpClient = $this->httpClientFactory ?? new Psr18Client();
        $this->httpRequest = $this->httpRequestFactory ?? (
            $this->httpClientFactory instanceof RequestFactoryInterface
            && $this->httpClientFactory instanceof StreamFactoryInterface
            && $this->httpClientFactory instanceof UriFactoryInterface
            ? $this->httpClientFactory
            : new Psr17Factory()
        );
    }

    public function request(RequestInterface $request): mixed
    {
        $response = $this->getResponse($request);

        return $request->parseResponse($response);
    }

    protected function validateRequest(RequestInterface $request): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
        $violations = $validator->validate($request);
        if (count($violations) > 0) {
            $messages = [];
            foreach ($violations as $violation) {
                $messages[] = $violation->getMessage();
            }

            throw new \InvalidArgumentException(implode("\n", $messages), 400);
        }
    }

    protected function getRequest(RequestInterface $request): HttpRequestInterface
    {
        $this->validateRequest($request);

        $body = json_encode(array_merge(['key' => $this->apiKey], $request->getHttpBody()), JSON_THROW_ON_ERROR);
        $stream = $this->httpRequest->createStream($body);

        return $this->httpRequest->createRequest(
            method: $request->getHttpMethod(),
            uri: $this->httpRequest->createUri('https://api.windy.com')->withPath($request->getEndpoint()),
        )
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody($stream);
    }

    protected function getResponse(RequestInterface $request): ResponseInterface
    {
        $httpRequest = $this->getRequest($request);

        return $this->httpClient->sendRequest($httpRequest);
    }
}
