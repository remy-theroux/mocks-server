<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Amp\ByteStream\ResourceOutputStream;
use Amp\Socket;
use Amp\Log\StreamHandler;
use Amp\Http\Server\Server;
use Amp\Log\ConsoleFormatter;
use Mocks\Server\Config\Loader;
use Mocks\Server\RequestHandler\RequestHandler;
use Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

Amp\Loop::run(static function () {
    $logHandler = new StreamHandler(new ResourceOutputStream(\STDOUT));
    $logHandler->setFormatter(new ConsoleFormatter());
    $logger = new Logger('server');
    $logger->pushHandler($logHandler);

    $loader = new Loader($logger);
    $mocks  = $loader->loadConfig('requests-stubs.yaml');
    if (null === $mocks) {
        throw new InvalidConfigurationException('Cannot load requests-stubs configuration file');
    }

    $requestHandler = new RequestHandler($logger, $mocks);
    $servers        = [
        Socket\listen('0.0.0.0:' . $mocks->getPort()),
        Socket\listen('[::]:' . $mocks->getPort()),
    ];
    $server         = new Server($servers, $requestHandler, $logger);
    yield $server->start();

    // Stop the server when SIGINT is received (this is technically optional, but it is best to call Server::stop()).
    Amp\Loop::onSignal(SIGINT, static function (string $watcherId) use ($server) {
        Amp\Loop::cancel($watcherId);

        yield $server->stop();
    });
});
