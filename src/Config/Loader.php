<?php
declare(strict_types=1);

namespace Mocks\Server\Config;

use Mocks\Server\Models\Mocks;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class Loader
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function loadConfig(string $yamlFilePath): ?Mocks
    {
        try {
            $data = Yaml::parseFile($yamlFilePath);
        } catch (ParseException $exception) {
            $this->logger->error('Error while parsing yaml file', [
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        $this->validateConfig($data);

var_dump($data);
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());
        $mocks = $normalizer->denormalize($data['mocks'], Mocks::class);
var_dump($mocks);
        return $mocks;
    }

    private function validateConfig(array $config): void
    {
        $processor = new Processor();
        $processor->processConfiguration(new MocksServerConfiguration(), $config);
    }
}