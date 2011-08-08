<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

class PathUniqueValidator extends ConstraintValidator
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $pathRepository;
    /**
     * @var \Zenstruck\Bundle\ContentBundle\Repository\NodeRepository
     */
    protected $nodeRepository;

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    public function __construct(EntityManager $em)
    {
        $this->pathRepository = $em->getRepository('ZenstruckContentBundle:Path');
        $this->nodeRepository = $em->getRepository('ZenstruckContentBundle:Node');
    }

    /**
     * @param \Zenstruck\Bundle\ContentBundle\Entity\Node $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     * @return bool
     */
    public function isValid($value, Constraint $constraint)
    {
        $path = $value->getPrimaryPath();
        if (null === $path) {

            return true;
        }
        $conflicts = $this->pathRepository->findBy(array('uri' => $path->getUri()));
        if (empty($conflicts)) {

            return true;
        }

        /* @var \Zenstruck\Bundle\ContentBundle\Entity\Path $old */
        $old = $value->getOldPrimaryPath();
        if (!is_object($old)) {
            $this->setMessage($constraint->message);
            
            return false;
        }

        foreach ($conflicts as $conflict) {
            /* @var \Zenstruck\Bundle\ContentBundle\Entity\Path $conflict */
            if (($conflict->getId() != $old->getId()) && $this->nodeRepository->findOneByPath($conflict)) {
                $this->setMessage($constraint->message);
                
                return false;
            }
        }

        return true;
    }
    
}
