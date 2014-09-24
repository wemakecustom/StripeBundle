<?php

namespace WMC\StripeBundle\Twig;

class StripeExtension extends \Twig_Extension
{

    protected $publishableKey;

    public function __construct($publishableKey)
    {
        $this->publishableKey = $publishableKey;
    }

    public function getGlobals()
    {
        return array(
            'stripe_publishable_key' => $this->publishableKey,
        );

    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wmc_stripe.stripe.twig_extension';
    }
}