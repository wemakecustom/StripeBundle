<?php

namespace WMC\StripeBundle\Service;


class StripeService extends \Stripe
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