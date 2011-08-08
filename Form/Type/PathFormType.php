<?php

namespace Zenstruck\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Zenstruck\Bundle\ContentBundle\Form\DataTransformer\PathToStringTransformer;

class PathFormType extends AbstractType
{
    /**
     * @var \Zenstruck\Bundle\ContentBundle\Form\DataTransformer\PathToStringTransformer
     */
    protected $pathToStringTransformer;

    public function __construct(PathToStringTransformer $pathToStringTransformer)
    {
        $this->pathToStringTransformer = $pathToStringTransformer;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->appendClientTransformer($this->pathToStringTransformer);
    }

    public function getParent(array $options)
    {
        return 'text';
    }

    public function getName()
    {
        return 'zenstruck_content_path';
    }
}