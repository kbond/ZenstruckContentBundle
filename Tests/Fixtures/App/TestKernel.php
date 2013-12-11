<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class TestKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Zenstruck\Bundle\ContentBundle\ZenstruckContentBundle(),
            new \Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\ContentTestBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Dpn\XmlSitemapBundle\DpnXmlSitemapBundle()
        );

        // check for Symfony 2.0
        if (version_compare(self::VERSION, '2.1', '<')) {
            $bundles[] = new \Symfony\Bundle\DoctrineBundle\DoctrineBundle();
        } else {
            $bundles[] = new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/default.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/logs';
    }
}
