<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ManufacturerType
 * @package Darkroom\ModelBundle\Form\Chemistry
 */
class ManufacturerType extends AbstractType
{
    /**
     * @param FormBuilderInterface  $builder
     * @param array                 $options
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
                'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\Manufacturer',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkroom_modelbundle_manufacturer';
    }
}
