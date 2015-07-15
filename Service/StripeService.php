<?php

namespace WMC\StripeBundle\Service;

use Stripe\Stripe;

class StripeService extends Stripe
{
    protected $secretKey;

    function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
        self::setApiKey($secretKey);

        return $this;
    }

    public function auth()
    {
        self::setApiKey($this->secretKey);
    }
}
