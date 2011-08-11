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

    protected $nodeClass;

    /**
     * @param string $contentTypes
     * @param string $nodeClass
     */
    public function __construct($contentTypes, $nodeClass)
    {
        $this->contentTypes = $contentTypes;
        $this->nodeClass = $nodeClass;
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

        $this->contentTypes[$this->nodeClass] = 'node';

        if ($classMetadata->name == $this->nodeClass) {

            $classMetadata->subClasses = $subclasses;

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
