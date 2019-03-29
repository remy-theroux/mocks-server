<?php
declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use Amp\Socket;
use Monolog\Logger;
use Amp\Log\StreamHandler;
use Amp\Http\Server\Server;
use Amp\Log\ConsoleFormatter;
use Amp\ByteStream\ResourceOutputStream;
use Mocks\Server\RequestHandler\RequestHandler;
use Mocks\Server\Config\Loader;

Amp\Loop::run(function () {
    $servers = [
        Socket\listen('0.0.0.0:1337'),
        Socket\listen('[::]:1337'),
    ];

    $logHandler = new StreamHandler(new ResourceOutputStream(\STDOUT));
    $logHandler->setFormatter(new ConsoleFormatter());
    $logger = new Logger('server');
    $logger->pushHandler($logHandler);

    $loader = new Loader($logger);
    $mocks = $loader->loadConfig('mocks-server.yaml');

    $requestHandler = new RequestHandler($logger, $mocks);
    $server = new Server($servers, $requestHandler, $logger);
    yield $server->start();

    // Stop the server when SIGINT is received (this is technically optional, but it is best to call Server::stop()).
    Amp\Loop::onSignal(SIGINT, function (string $watcherId) use ($server) {
        Amp\Loop::cancel($watcherId);

        yield $server->stop();
    });
});
