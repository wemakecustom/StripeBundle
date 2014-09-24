<?php

namespace WMC\StripeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CardFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('card', 'text', array('required' => true, 'attr' => array('data-stripe' => 'number')))
            ->add('cvc', 'text', array('required' => true, 'attr' => array('data-stripe' => 'cvc')))
            ->add('month', 'text', array('required' => true, 'attr' => array('data-stripe' => 'exp-month')))
            ->add('year', 'text', array('required' => true, 'attr' => array('data-stripe' => 'exp-year')))
            ->add('token', 'hidden');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array()
        );
    }

    public function getName()
    {
        return 'wmc_stripebundle_cardformtype';
    }
}
