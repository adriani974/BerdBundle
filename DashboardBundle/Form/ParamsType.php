<?php

namespace Berd\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParamsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paramKey')
            ->add('operator')
            ->add('paramValue')
            ->add('userId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\DashboardBundle\Entity\Params'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_dashboardbundle_params';
    }
}
