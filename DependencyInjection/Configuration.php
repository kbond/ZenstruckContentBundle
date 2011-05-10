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
                ->arrayNode('content_types')                    
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}