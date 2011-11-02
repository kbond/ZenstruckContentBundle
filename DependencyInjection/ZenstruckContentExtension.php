<?php

/*
 * This file is part of the ZenstruckRedirectBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class ZenstruckContentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('manager.xml');
        $loader->load('listener.xml');
        $loader->load('validator.xml');

        $container->getDefinition('zenstruck_content.manager')
                    ->replaceArgument(1, $config['node_class'])
                    ->replaceArgument(2, array_merge(array($config['node_type_name'] => $config['node_class']), $config['content_types']));

        // get content types defined in config
        $content_types = array_flip($config['content_types']);
        $content_types[$config['node_class']] = 'node';

        $container->getDefinition('zenstruck_content.listener.discriminator')
                    ->replaceArgument(0, $content_types)
                    ->replaceArgument(1, $config['inheritance_type'])
                    ->replaceArgument(2, $config['discriminator_column']);

        if ($config['use_controller']) {
            $loader->load('controller.xml');

            $container->getDefinition('zenstruck_content.controller')
                        ->replaceArgument(1, $config['default_template']);
        }
        if ($config['use_form']) {
            $loader->load('form.xml');
        }
    }

}
