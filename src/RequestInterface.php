<?php

declare(strict_types=1);

namespace Lsv\Windy;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

interface RequestInterface
{
    public static function validate(self $request, ExecutionContextInterface $context): void;

    public function getHttpMethod(): string;

    /**
     * @return array<string, mixed>
     */
    public function getHttpBody(): array;

    public function getEndpoint(): string;

    public function parseResponse(ResponseInterface $response): mixed;
}
