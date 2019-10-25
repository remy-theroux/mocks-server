<?php

declare(strict_types=1);

namespace Mocks\Server\Models;

/**
 * Request model for a configured mock. It's associated with a Response object.
 */
final class Request
{
    /** @var string */
    private $uri;

    /** @var string */
    private $method;

    /** @var int */
    private $delay;

    public function __construct(string $uri, string $method, int $delay)
    {
        $this->uri    = $uri;
        $this->method = $method;
        $this->delay  = $delay;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
