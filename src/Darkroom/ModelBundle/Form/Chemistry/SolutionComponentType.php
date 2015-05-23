<?php

namespace Darkroom\ModelBundle\Form\Chemistry;

use Doctrine\ORM\EntityRepository;
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
                    //'property'  => 'name',
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('s')
                            ->where('s.stockSolution = 1')
                            ->add('orderBy', 's.dateMixed ASC');
                    }
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
