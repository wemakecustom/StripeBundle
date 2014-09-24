<?php

namespace WMC\StripeBundle\Form\Handler;

use Symfony\Component\Form\FormInterface,
    Symfony\Component\HttpFoundation\Request;

class CardFormHandler
{

    protected $form;
    protected $request;
    protected $description;
    protected $customer;

    public function __construct(FormInterface $form, Request $request, $description)
    {
        $this->form = $form;
        $this->request = $request;
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData()['token']);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess($token)
    {
        $customer = \Stripe_Customer::create(
            array(
                "card" => $token,
                "description" => '' . $this->description
            )
        );

        $this->customer = $customer;
    }

    /**
     * @return \Stripe_Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}