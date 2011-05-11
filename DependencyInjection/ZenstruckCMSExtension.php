<?php

namespace Zenstruck\Bundle\CMSBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class ZenstruckCMSExtension extends Extension
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
        
        $container->getDefinition('zenstruck.cms.listener.discriminator')
                    ->replaceArgument(0, $content_types);
    }

}
