<?php

namespace Zenstruck\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class ZenstruckContentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('listener.xml');

        // get content types defined in config
        $content_types = array_flip($config['content_types']);
        $content_types[$config['node_class']] = 'node';

        $container->getDefinition('zenstruck_content.listener.discriminator')
                    ->replaceArgument(0, $content_types);

        if ($config['use_controller']) {
            $loader->load('controller.xml');

            $container->getDefinition('zenstruck_content.controller')
                        ->replaceArgument(1, $config['default_template']);
        }


    }

}
