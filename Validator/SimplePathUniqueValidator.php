<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

class SimplePathUniqueValidator extends ConstraintValidator
{
    /**
     * @var \Zenstruck\Bundle\ContentBundle\Repository\NodeRepository
     */
    protected $nodeRepository;

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    public function __construct(EntityManager $em)
    {
        $this->nodeRepository = $em->getRepository('ZenstruckContentBundle:Node');
    }

    /**
     * @param \Zenstruck\Bundle\ContentBundle\Entity\Node $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     * @return bool
     */
    public function isValid($value, Constraint $constraint)
    {
        if (null === $value) {

            return true;
        }
        $conflicts = $this->nodeRepository->findBy(array('path' => $value->getPath()));
        if (empty($conflicts)) {

            return true;
        }

        foreach ($conflicts as $conflict) {
            /* @var \Zenstruck\Bundle\ContentBundle\Entity\Node $conflict */
            if ($conflict->getId() != $value->getId()) {
                $this->setMessage($constraint->message);
                
                return false;
            }
        }

        return true;
    }
    
}
