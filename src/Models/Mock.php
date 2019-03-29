<?php
declare(strict_types=1);

namespace Mocks\Server\Models;

final class Mock
{
    /** @var string */
    private $uri;

    /** @var string */
    private $method;

    /** @var int */
    private $delay;

    /** @var int */
    private $status;

    /** @var string */
    private $mimeType;

    /** @var string */
    private $rawBody;

    public function __construct(string $uri, string $method, int $delay, int $status, string $mimeType, string $rawBody)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->delay = $delay;
        $this->status = $status;
        $this->mimeType = $mimeType;
        $this->rawBody = $rawBody;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getRawBody(): string
    {
        return $this->rawBody;
    }
}