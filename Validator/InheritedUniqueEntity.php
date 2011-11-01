<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class InheritedUniqueEntity extends Constraint
{
    public $message = 'This value is already used.';
    public $field = null;

    public function getRequiredOptions()
    {
        return array('field');
    }

    public function validatedBy()
    {
        return 'zenstruck_content.validator.inherited_unique_entity';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getDefaultOption()
    {
        return 'field';
    }
}
