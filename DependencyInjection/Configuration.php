<?php

namespace Zenstruck\Bundle\CMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zenstruck_cms');

        $rootNode
            ->children()
                ->booleanNode('use_controller')->defaultTrue()->end()
                ->scalarNode('node_class')->defaultValue('Zenstruck\\Bundle\\CMSBundle\\Entity\\Node')->end()
                ->arrayNode('content_types')
                    ->useAttributeAsKey('key')
                    ->prototype('scalar')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}