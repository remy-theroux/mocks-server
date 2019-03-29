<?php
declare(strict_types=1);

namespace Mocks\Server\Models;

final class Mocks
{
    /** @var int */
    private $port;

    /** @var string */
    private $mimeType;

    /** @var Mock[] */
    private $mocks;

    public function __construct(int $port, string $mimeType, array $mocks)
    {
        $this->port = $port;
        $this->mimeType = $mimeType;
        $this->mocks = $mocks;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getMocks(): array
    {
        return $this->mocks;
    }
}