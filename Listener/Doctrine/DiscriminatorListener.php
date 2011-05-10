<?php

namespace Zenstruck\Bundle\CMSBundle\Listener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;


/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class DiscriminatorListener implements EventSubscriber
{
    public function getSubscribedEvents() 
    {  
        return array(Events::loadClassMetadata);
    }  
    
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        
        /*if ($classMetadata->table['name'] == 'Node')
            die(var_dump($classMetadata));*/
        
    }
}
