<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\TransferStats;

/**
 * Main context shared between feature contexts.
 */
class MainContext implements Context
{
    /** @var int */
    protected $port;

    /** @var Client */
    protected $client;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var TransferStats */
    protected $requestStats;

    public function __construct(int $port)
    {
        $this->port = $port;
        $this->client = new Client();
    }

    /**
     * @Given I prepare a :method request on :url
     */
    public function iPrepareARequestOn(string $method, string $uri): void
    {
        $this->request = new Request($method, $uri);
    }

    /**
     * @When i send the request
     */
    public function iSendTheRequest(): void
    {
        $options = [
            'on_stats'        => function (TransferStats $stats) {
                $this->requestStats = $stats;
            },
        ];

        $this->client->send($this->request, $options);
    }

    /**
     * @Then the response should contain the following JSON
     */
    public function theResponseShouldContainTheFollowingJson(PyStringNode $string): bool
    {
        return $this->response->getBody() === $string->getRaw();
    }

    /**
     * @Then the status code should be :statusCode
     */
    public function theStatusCodeShouldBe($statusCode): bool
    {
        return $this->response->getStatusCode() === $statusCode;
    }

    /**
     * @Then the request should take a delay of :arg1
     */
    public function theRequestShouldTakeADelayOf($delay): bool
    {
        return $this->requestStats->getTransferTime() >= $delay;
    }
}
