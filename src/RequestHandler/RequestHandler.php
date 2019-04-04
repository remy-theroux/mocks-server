<?php
declare(strict_types=1);

namespace Mocks\Server\RequestHandler;

use function Amp\call;
use Amp\Delayed;
use Amp\Failure;
use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler as RequestHandlerInterface;
use Amp\Http\Server\Response;
use Amp\Promise;
use Amp\Success;
use Mocks\Server\Exception\NoMockFoundException;
use Mocks\Server\Models\Mock;
use Mocks\Server\Models\Mocks;
use Psr\Log\LoggerInterface;

final class RequestHandler implements RequestHandlerInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Mocks */
    private $mocks;

    public function __construct(LoggerInterface $logger, Mocks $mocks)
    {
        $this->logger = $logger;
        $this->mocks = $mocks;
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
        if (0 === count($mocks)) {
            return new Failure(new NoMockFoundException($request));
        }

        /** @var Mock $mock */
        $mock = array_shift($mocks);

        return call(function() use ($mock) {
            yield new Delayed($mock->getDelay() * 1000);

            return new Success(
                new Response(
                    $mock->getStatus(),
                    [
                        'content-type' => $mock->getMimeType(),
                    ],
                    $mock->getRawBody()
                )
            );
        });
    }

    private function filterMocksFromRequest(Request $request): ?array
    {
        return array_filter($this->mocks->getMocks(), function(Mock $mock) use ($request) {
            return $mock->getMethod() === $request->getMethod()
                && $mock->getUri() === $request->getUri()->getPath();
        });
    }
}
