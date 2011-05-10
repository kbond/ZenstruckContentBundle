<?php

namespace Zenstruck\Bundle\CMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zenstruck_version');

        $rootNode
            ->children()
                ->booleanNode('enabled')->defaultFalse()->end()
                ->node('version', 'variable')->defaultFalse()->end()
                ->node('file', 'variable')->defaultValue('%kernel.root_dir%/../VERSION')->end()
                ->node('text', 'variable')->defaultFalse()->end()
                ->booleanNode('toolbar')->defaultFalse()->end()
                ->arrayNode('block')
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->node('position', 'variable')->defaultValue('vb-bottom-right')->end()
                        ->node('prefix', 'variable')->defaultValue('Version: ')->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}