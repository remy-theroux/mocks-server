<?php
declare(strict_types=1);

namespace Mocks\Server\Models;

final class Mock
{
    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}