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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
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
