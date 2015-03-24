<?php

namespace Berd\EventLogsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomAction')
            ->add('dateAction')
            ->add('description')
            ->add('userId')
            ->add('idLogs')
            ->add('idDevice')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\EventLogsBundle\Entity\Actions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_eventlogsbundle_actions';
    }
}
