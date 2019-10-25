<?php

declare(strict_types=1);

namespace Mocks\Server\Models;

/**
 * Response model for a configured mock. It's associated with a Request object.
 */
final class Response
{
    /** @var int */
    private $status;

    /** @var string */
    private $mimeType;

    /** @var string */
    private $rawBody;

    public function __construct(int $status, string $mimeType, string $rawBody)
    {
        $this->status   = $status;
        $this->mimeType = $mimeType;
        $this->rawBody  = $rawBody;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getRawBody(): string
    {
        return $this->rawBody;
    }
}
