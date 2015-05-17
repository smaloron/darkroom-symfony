<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ChemicalSolutionType
 * @package Darkroom\ModelBundle\Form\Chemistry
 */
class ChemicalSolutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('notes', 'textarea')
            ->add('dateMixed', 'date')
            ->add('initialVolume', 'number')
            ->add('waterVolume', 'number')
            ->add('stockSolution', 'checkbox')
            ->add('oneUse', 'checkbox')
            ->add(
                'container',
                'entity',
                array(
                    'class' => 'Darkroom\ModelBundle\Entity\Chemistry\SolutionContainer',
                    'property' => 'name',
                    'required' => false,
                )
            )
            ->add(
                'recipe',
                'entity',
                array(
                    'class' => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe',
                    'property' => 'name',
                )
            )
            ->add(
                'components',
                'collection',
                array(
                    'type' => new SolutionComponentType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'prototype' => true,
                )
            )
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkroom_modelbundle_chemicalsolution';
    }
}
