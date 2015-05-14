<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('abbrev', 'text')
            ->add('conversionRate', 'number')
            ->add(
                'unitCategory',
                'entity',
                array(
                    'class' => 'DarkroomModelsBundle:UnitCategory',
                    'property' => 'name',
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
            'data_class' => 'Darkroom\ModelBundle\Entity\Chemistry\Unit',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'smaloron_darkroom_modelsbundle_unit';
    }
}
