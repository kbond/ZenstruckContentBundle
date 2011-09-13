<?php

namespace Zenstruck\Bundle\ContentBundle\DependencyInjection;

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
                ->scalarNode('node_class')->isRequired()->end()
                ->booleanNode('use_controller')->defaultFalse()->end()
                ->booleanNode('use_form')->defaultFalse()->end()
                ->scalarNode('inheritance_type')->defaultValue('class_table')->end()
                ->scalarNode('discriminator_column')->defaultValue('content_type')->end()
                ->scalarNode('default_template')->defaultValue('ZenstruckContentBundle:Node:node.html.twig')->end()
                ->arrayNode('content_types')
                    ->useAttributeAsKey('key')
                    ->prototype('scalar')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}