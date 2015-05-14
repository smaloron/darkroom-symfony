<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UnitCategoryType
 * @package Darkroom\ModelBundle\Form\Chemistry
 */
class UnitCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array (
                'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\UnitCategory',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smaloron_darkroom_modelsbundle_unitCategory';
    }
}
