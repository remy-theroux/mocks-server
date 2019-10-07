<?php

declare(strict_types=1);

namespace Mocks\Server\Exception;

use Amp\Http\Server\Request;

class NoMockFoundException extends \Exception
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        parent::__construct('No mock found for request');
    }
}
