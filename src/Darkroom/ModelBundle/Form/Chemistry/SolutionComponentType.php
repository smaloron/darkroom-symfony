<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolutionComponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'component',
                'entity',
                array(
                    'class'     => 'Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution',
                    'property'  => 'name',
                )
            )
            ->add('volume', 'number');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\SolutionComponent',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkroom_modelbundle_solutioncomponent';
    }
}
