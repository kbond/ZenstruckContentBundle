<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Zenstruck\Bundle\ContentBundle\Entity\NodeManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class InheritedUniqueEntityValidator extends ConstraintValidator
{
    /** @var \Zenstruck\Bundle\ContentBundle\Entity\NodeManager */
    protected $nodeManager;

    /**
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    public function __construct(NodeManager $nodeManager)
    {
        $this->nodeManager = $nodeManager;
    }

    /**
     * @param  \Zenstruck\Bundle\ContentBundle\Entity\Node $node
     * @param  \Symfony\Component\Validator\Constraint     $constraint
     * @return bool
     */
    public function validate($node, Constraint $constraint)
    {
        if (null === $node) {
            return true;
        }

        $em = $this->nodeManager->getEntityManager();

        $className = $this->context->getClassName();
        $class = $em->getClassMetadata($className);
        $fieldName = $constraint->field;

        // make sure to set class name at topmost parent that has field
        $className = $class->reflFields[$fieldName]->class;

        if ($className === 'Zenstruck\Bundle\ContentBundle\Entity\Node') {
            // avoid instanciating top level abstract class
            $repo = $this->nodeManager->getRepository();
        } else {
            $repo = $em->getRepository($className);
        }

        if (!isset($class->reflFields[$fieldName])) {
            throw new ConstraintDefinitionException("Only field names mapped by Doctrine can be validated for uniqueness.");
        }

        $fieldValue = $class->reflFields[$fieldName]->getValue($node);

        // leave alone if blank (let NotBlank constraint handle)
        if (null === $fieldValue) {
            return true;
        }

        $conflicts = $repo->findBy(array($fieldName => $fieldValue));

        if (empty($conflicts)) {
            return true;
        }

        foreach ($conflicts as $conflict) {
            /* @var \Zenstruck\Bundle\ContentBundle\Entity\Node $conflict */
            if ($conflict->getId() != $node->getId()) {
                $this->context->buildViolation($constraint->message)
                    ->atPath($fieldName)
                    ->addViolation()
                ;
            }
        }

        return true;
    }

}
