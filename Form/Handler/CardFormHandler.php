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
    protected $data;

    public function __construct(FormInterface $form, Request $request, $description)
    {
        $this->form = $form;
        $this->request = $request;
        $this->description = $description;
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData());

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(array $data)
    {
        $customer = \Stripe_Customer::create(
            array(
                "card" => $data['token'],
                "description" => '' . $this->description
            )
        );
        
        $this->data = $data;
        $this->customer = $customer;
    }

    /**
     * No critical card information here. Card information are deleted by the js before form submit for security
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \Stripe_Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
