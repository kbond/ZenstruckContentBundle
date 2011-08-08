<?php

namespace Zenstruck\Bundle\ContentBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Zenstruck\Bundle\ContentBundle\Entity\Path;

class PathToStringTransformer implements DataTransformerInterface
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('ZenstruckContentBundle:Path');
    }

    /**
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @param \Zenstruck\Bundle\ContentBundle\Entity\Path $value
     * @return null|string
     */
    function transform($value)
    {
        if (null === $value) {
            return null;
        }
        if (!$value instanceof Path) {
            throw new UnexpectedTypeException($value, 'Zenstruck\Bundle\ContentBundle\Entity\Path');
        }

        return $value->getUri();
    }

    /**
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @param string $value
     * @return null|\Zenstruck\Bundle\ContentBundle\Entity\Path
     */
    function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
        
        $object = $this->repository->findOneBy(array('uri' => $value));
        if (null === $object) {
            $object = new Path($value);
        }

        return $object;
    }

}