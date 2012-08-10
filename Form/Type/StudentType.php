<?php

namespace IMAG\PhdCallBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface
    ;

class StudentType extends AbstractType
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
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMAG\PhdCallBundle\Entity\Student',
        ));
    }

    public function getName()
    {
        return 'Student';
    }
}