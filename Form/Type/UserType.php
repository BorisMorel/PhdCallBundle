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
            ;
        
        if (true === $options['allowedRolesChoices']) {
            $builder
                ->add('roles', 'choice', array(
                    'choices' => $options['ctrlOptions']['choices'],
                    'multiple' => true,
                    'expanded' => true,
                ));                
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMAG\PhdCallBundle\Entity\User',
            'ctrlOptions' => array(
                'choices' => array(
                    'ROLE_USER' => 'User',
                    'ROLE_REVIEWER' => 'Reviewer',
                    'ROLE_ADMIN' => 'Admin'
                )
            ),
            'allowedRolesChoices' => false,
        ));
    }

    public function getName()
    {
        return 'User';
    }
}