<?php

namespace Zenstruck\Bundle\ContentBundle\Listener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class DiscriminatorListener implements EventSubscriber
{

    protected $contentTypes;

    /**
     * @param string $contentTypes
     */
    public function __construct($contentTypes)
    {
        $this->contentTypes = $contentTypes;
    }

    public function getSubscribedEvents()
    {
        return array(Events::loadClassMetadata);
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();

        // add subclasses to node
        $subclasses = array_flip($this->contentTypes);

        if ($classMetadata->name == $subclasses['node']) {
            unset($subclasses['node']);
            $classMetadata->subClasses = $subclasses;

            // setup node inheritance
            $classMetadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_JOINED);
            $classMetadata->setDiscriminatorColumn(array(
                'name' => 'content_type',
                'type' => 'string',
                'length' => 50
            ));
        }

        // check if class is defined in config
        if (isset($this->contentTypes[$classMetadata->name])) {
            // set discriminator
            $classMetadata->discriminatorMap = array_flip($this->contentTypes);
            $classMetadata->discriminatorValue = $this->contentTypes[$classMetadata->name];
        }
    }

}
