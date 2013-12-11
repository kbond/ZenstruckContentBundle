<?php

/*
 * This file is part of the ZenstruckContentBundle package.
 *
 * (c) Kevin Bond <http://zenstruck.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class NodeBaseFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('path');
    }

    public function getName()
    {
        return 'zenstruck_content_node_base';
    }

}
