<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ChemicalRecipeType
 * @package Darkroom\ModelBundle\Form\Chemistry
 */
class ChemicalRecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('notes', 'textarea', array('required' => false))
            ->add(
                'recipeCategory',
                'entity',
                array(
                    'class' => 'Darkroom\ModelBundle\Entity\Chemistry\RecipeCategory',
                    'property' => 'name',
                )
            )
            ->add(
                'manufacturer',
                'entity',
                array(
                    'class' => 'Darkroom\ModelBundle\Entity\Chemistry\Manufacturer',
                    'property' => 'name',
                )
            )
            ->add(
                'components',
                'collection',
                array(
                    'type' => new RecipeComponentType(),
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
            'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smaloron_darkroom_modelsbundle_chemicalrecipe';
    }
}