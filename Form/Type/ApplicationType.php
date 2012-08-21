<?php

namespace IMAG\PhdCallBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface
    ;


class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motivation')
            ->add('career', 'collection', array(
            'type' => 'text',
            'options' => array(
                'required' => false,
                'attr' => array('class' => 'career-box')
            ),
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMAG\PhdCallBundle\Entity\Application',
        ));
    }

    public function getName()
    {
        return 'Application';
    }
 
}
