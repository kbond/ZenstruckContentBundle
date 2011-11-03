<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zenstruck_cms');

        $rootNode
            ->children()
                ->scalarNode('node_class')->isRequired()->end()
                ->scalarNode('node_type_name')->defaultValue('node')->end()
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