<?php
declare(strict_types=1);

namespace Mocks\Server\RequestHandler;

use Amp\Http\Server\Request;
use Amp\Http\Server\RequestHandler as RequestHandlerInterface;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Promise;
use Amp\Success;
use Mocks\Server\Models\Mocks;
use Psr\Log\LoggerInterface;

final class RequestHandler implements RequestHandlerInterface {

    /** @var LoggerInterface */
    private $logger;

    /** @var Mocks */
    private $mocksConfig;

    public function __construct(LoggerInterface $logger, Mocks $mocksConfig)
    {
        $this->logger = $logger;
        $this->mocksConfig = $mocksConfig;
    }


    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request): Promise
    {
        $this->logger->debug('Handle server request from request handler', [
            'request' => $request,
        ]);

        return new Success(
            new Response(
                Status::OK,
                [
                    'content-type' => 'text/plain; charset=utf-8',
                ],
                'Hello, World!'
            )
        );
    }
}
