<?php

namespace Zenstruck\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

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