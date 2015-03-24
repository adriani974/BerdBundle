<?php

namespace Berd\EventLogsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeviceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modele')
            ->add('osArchitecture')
            ->add('height')
            ->add('width')
            ->add('netmask')
            ->add('userId')
            ->add('deviceId')
            ->add('manufacturer')
            ->add('version')
            ->add('others')
            ->add('isWeb')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Berd\EventLogsBundle\Entity\Device'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'berd_eventlogsbundle_device';
    }
}
