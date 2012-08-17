<?php

namespace IMAG\PhdCallBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface
    ;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('address')
            ->add('zip')
            ->add('city')
            ->add('roles', 'choice', array(
                'choices' => $options['ctrlOptions']['choices'],
                'multiple' => false,
                'expanded' => true,
                'data' => 'ROLE_USER'
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMAG\PhdCallBundle\Entity\User',
            'ctrlOptions' => array(
                'choices' => array()
            )));
    }

    public function getName()
    {
        return 'User';
    }
}