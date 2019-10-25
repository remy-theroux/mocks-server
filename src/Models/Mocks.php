<?php

declare(strict_types=1);

namespace Mocks\Server\Models;

/**
 * Store all configured mocks and root configurations
 */
final class Mocks
{
    /** @var int */
    private $port;

    /** @var Mock[] */
    private $mocks;

    public function __construct(int $port, array $mocks)
    {
        $this->port  = $port;
        $this->mocks = $mocks;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return array|Mock[]
     */
    public function getMocks(): array
    {
        return $this->mocks;
    }
}
