<?php

namespace AppBundle\Form;

use WMC\StripeBundle\Form\Type\CardFormType;
use Symfony\Component\Form\FormBuilderInterface;

class CardFormCvcType extends CardFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // Add default fields.

        $builder->add('cvc', 'integer', array(
            'required' => true,
            'attr' => array('data-stripe' => 'cvc'),
            'label' => 'form.card.cvc',
            'translation_domain' => 'WMCStripeBundle',
        )
    );
    }
}
