<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Zenstruck\Bundle\ContentBundle\Entity\NodeManager;

class SimplePathUniqueValidator extends ConstraintValidator
{
    /**
     * @var \Zenstruck\Bundle\ContentBundle\Repository\NodeRepository
     */
    protected $nodeRepository;

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    public function __construct(NodeManager $nodeManager)
    {
        $this->nodeRepository = $nodeManager->getRepository();
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
                $oldPath = $this->context->getPropertyPath();
                $this->context->setPropertyPath( empty($oldPath) ? 'path' : $oldPath.".path");
                $this->context->addViolation($constraint->message, array(), $value->getPath());
                $this->context->setPropertyPath($oldPath);
            }
        }

        return true;
    }

}
