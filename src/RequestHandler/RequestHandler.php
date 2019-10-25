<?php

declare(strict_types=1);

namespace Mocks\Server\RequestHandler;

use Amp\Delayed;
use Amp\Failure;
use Amp\Promise;
use Amp\Success;
use function Amp\call;
use Amp\Http\Server\Request;
use const Grpc\STATUS_NOT_FOUND;
use Psr\Log\LoggerInterface;
use Amp\Http\Server\Response;
use Mocks\Server\Models\Mock;
use Mocks\Server\Models\Mocks;
use Mocks\Server\Exception\NoMockFoundException;
use Amp\Http\Server\RequestHandler as RequestHandlerInterface;

/**
 * Handle requests receive on PHP server
 */
final class RequestHandler implements RequestHandlerInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Mocks */
    private $mocks;

    private static $notFoundReponseBody = <<<JSON
{
    "error": "No mock found for request"
}
JSON;

    /**
     * RequestHandler constructor.
     */
    public function __construct(LoggerInterface $logger, Mocks $mocks)
    {
        $this->logger = $logger;
        $this->mocks  = $mocks;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request): Promise
    {
        $this->logger->debug('Handle server request from request handler', [
            'request' => $request,
        ]);

        $mocks = $this->filterMocksFromRequest($request);
        if (0 === \count($mocks)) {
            return new Success(
                new Response(
                    404,
                    [
                        'content-type' => 'application/json',
                    ],
                    sprintf(self::$notFoundReponseBody)
                )
            );
        }

        /** @var Mock $mock */
        $mock = array_shift($mocks);

        return call(function () use ($mock) {
            yield new Delayed($mock->getRequest()->getDelay() * 1000);

            return new Success(
                new Response(
                    $mock->getResponse()->getStatus(),
                    [
                        'content-type' => $mock->getResponse()->getMimeType(),
                    ],
                    $mock->getResponse()->getRawBody()
                )
            );
        });
    }

    private function filterMocksFromRequest(Request $request): ?array
    {
        return array_filter($this->mocks->getMocks(), function (Mock $mock) use ($request) {
            return $mock->getRequest()->getMethod() === $request->getMethod()
                   && $mock->getRequest()->getUri() === $request->getUri()->getPath();
        });
    }
}
