<?php

namespace Zenstruck\Bundle\ContentBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SimplePathUnique extends Constraint
{
    public $message = 'Path is already used';

    public function validatedBy()
    {
        return 'zenstruck_content.validator.simple_path_unique';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
