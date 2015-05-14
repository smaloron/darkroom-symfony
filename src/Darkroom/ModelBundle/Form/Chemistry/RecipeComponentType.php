<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeComponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'chemical',
                'entity',
                array(
                    'class'     => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct',
                    'property'  => 'name',
                )
            )
            /*
            ->add(
                'recipe',
                'entity',
                array(
                    'class'     => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe',
                    'property'  => 'name',
                )
            )*/
            ->add('quantity', 'number')
            ->add(
                'unit',
                'entity',
                array(
                    'class'     => 'Darkroom\ModelBundle\Entity\Chemistry\Unit',
                    'property'  => 'abbrev',
                )
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\RecipeComponent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smaloron_darkroom_modelsbundle_recipecomponent';
    }
}
