<?php

namespace Berd\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body')
            ->add('requestName')
            ->add('isEnable')
            ->add('isFixed')
            ->add('renderType')
            ->add('userId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\DashboardBundle\Entity\Request'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_dashboardbundle_request';
    }
}
