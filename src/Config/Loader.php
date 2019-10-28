<?php

declare(strict_types=1);

namespace Mocks\Server\Config;

use Psr\Log\LoggerInterface;
use Mocks\Server\Models\Mocks;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * Manage configuration validation and loading into Models class
 */
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
            $this->logger->error('Error while parsing requests-stubs yaml configuration file', [
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        $this->validateConfig($data);

        return $this->populateMocks($data);
    }

    private function validateConfig(array $config): void
    {
        $processor = new Processor();
        $processor->processConfiguration(new MocksServerConfiguration(), $config);
    }

    private function populateMocks(array $data): Mocks
    {
        $objectNormalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            new PhpDocExtractor()
        );

        $arrayDenormalizer = new ArrayDenormalizer();
        $serializer        = new Serializer([$objectNormalizer, $arrayDenormalizer]);

        return $serializer->denormalize($data['mocks'], Mocks::class);
    }
}
