<?php
declare(strict_types=1);

namespace Mocks\Server\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Manage configuration conformity and default values
 */
class MocksServerConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mocks');
        $rootNode
            ->children()
                ->integerNode('port')
                    ->isRequired()
                    ->min(0)
                ->end()
                ->arrayNode('mocks')
                    ->requiresAtLeastOneElement()
                    ->arrayPrototype()
                        ->children()
                            ->append($this->addRequestNode())
                            ->append($this->addResponseNode())
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    public function addRequestNode()
    {
        $treeBuilder = new TreeBuilder('request');

        $node = $treeBuilder->getRootNode()
            ->isRequired()
            ->children()
                ->enumNode('method')
                    ->values(['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTION'])
                    ->isRequired()
                ->end()
                    ->scalarNode('uri')
                    ->isRequired()
                ->end()
                ->integerNode('delay')
                    ->min(0)
                    ->defaultValue(0)
                ->end()
            ->end()
        ;

        return $node;
    }

    public function addResponseNode()
    {
        $treeBuilder = new TreeBuilder('response');

        $node = $treeBuilder->getRootNode()
            ->isRequired()
            ->children()
                ->integerNode('status')
                    ->isRequired()
                    ->min(0)
                ->end()
                ->scalarNode('mime_type')
                    ->defaultValue('application-json')
                ->end()
                ->scalarNode('raw_body')
                    ->defaultValue('{}')
                ->end()
            ->end()
        ;

        return $node;
    }
}