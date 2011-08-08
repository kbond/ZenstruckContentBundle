<?php

namespace Zenstruck\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Zenstruck\Bundle\ContentBundle\Listener\Form\FormListener;

class NodeBaseFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('primary_path', 'zenstruck_content_path');

        $builder->addEventSubscriber(new FormListener());
    }

    public function getName()
    {
        return 'zenstruck_content_node_base';
    }
    
}