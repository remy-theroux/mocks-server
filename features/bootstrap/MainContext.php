<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
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
    /** @var Client */
    protected $client;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var TransferStats */
    protected $requestStats;

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => 'http://localhost:9000/',
            ]
        );
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

        try {
            $this->client->send($this->request, $options);
        } catch (ClientException $exception) {

        } catch (ServerException $exception) {

        }
    }

    /**
     * @Then the response should contain the following JSON
     */
    public function theResponseShouldContainTheFollowingJson(PyStringNode $string): void
    {
        if (!$this->requestStats->hasResponse()) {
            throw new Exception('Cannot retrieve response body because request has no response');
        }

        $rawBody = $this->requestStats->getResponse()->getBody()->getContents();
        if ($rawBody !== $string->getRaw()) {
            throw new Exception('Response body mismatch expected one');
        }
    }

    /**
     * @Then the status code should be :statusCode
     */
    public function theStatusCodeShouldBe(int $statusCode): void
    {
        if (!$this->requestStats->hasResponse()) {
            throw new Exception('Cannot retrieve status code because request has no response');
        }

        if ($this->requestStats->getResponse()->getStatusCode() !== $statusCode) {
            throw new Exception('Response status code mismatch expected one');
        }
    }

    /**
     * @Then the request should take a delay of at least :arg1
     */
    public function theRequestShouldTakeADelayOfAtLeast(int $delay): void
    {
        if ($this->requestStats->getTransferTime() < $delay) {
            throw new Exception('Request delay mismatch expected one');
        }
    }
}
