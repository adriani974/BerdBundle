<?php

namespace Berd\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResultsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fieldList')
            ->add('dateCreation')
            ->add('request')
            ->add('userId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\DashboardBundle\Entity\Results'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_dashboardbundle_results';
    }
}
