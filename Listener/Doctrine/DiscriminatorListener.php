<?php

/*
 * This file is part of the ZenstruckRedirectBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    protected $inheritanceType;
    protected $discriminatorColumn;

    /**
     * @param string $contentTypes
     */
    public function __construct($contentTypes, $inhertianceType, $discriminatorColumn)
    {
        $this->contentTypes = $contentTypes;
        $this->inheritanceType = $inhertianceType;
        $this->discriminatorColumn = $discriminatorColumn;
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

            switch ($this->inheritanceType) {
                case 'single_table':
                    $classMetadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_SINGLE_TABLE);
                    break;

                case 'table_per_class':
                    $classMetadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_TABLE_PER_CLASS);
                    break;

                default:
                    $classMetadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_JOINED);
                    break;
            }



            $classMetadata->setDiscriminatorColumn(array(
                'name' => $this->discriminatorColumn,
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
