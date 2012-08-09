<?php

namespace IMAG\PhdCallBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface
    ;

class PhdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', null, array('required' => false))
            ->add('abstract', null, array('required' => false))
            ->add('file', 'file', array('required' => false))
            ;                  
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IMAG\PhdCallBundle\Entity\Phd',
            'validation_groups' => array('IMAG\PhdCallBundle\Entity\Phd', 'determineValidationGroups'),
        ));
    }

    public function getName()
    {
        return 'Phd';
    }
}