<?php

namespace IMAG\PhdCallBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface
    ;


class CareerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
          $builder
              ->add('year-start', 'text')
              ->add('year-end', 'text')
              ->add('description', 'textarea')
              ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       
    }

    public function getName()
    {
        return 'Career';
    }
 
}