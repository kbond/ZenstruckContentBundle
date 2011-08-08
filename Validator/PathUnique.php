<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PathUnique extends Constraint
{
    public $message = 'Path already exists.';

    public function validatedBy()
    {
        return 'zenstruck_content.validator.path_unique';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
