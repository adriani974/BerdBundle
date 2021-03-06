<?php

namespace Berd\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RequeteType extends AbstractType
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
			->add('renderType', 'choice', array(
									'choices'   => array('Line' => 'Line', 'Bar' => 'Bar', 'Radar' => 'Radar', 'PolarArea' => 'PolarArea', 'Pie' => 'Pie', 'Doughnut' => 'Doughnut'),
									'required'  => false,
								))
            ->add('userId')
            ->add('requestList')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\DashboardBundle\Entity\Requete'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_dashboardbundle_requete';
    }
}
