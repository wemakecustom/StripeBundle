<?php

namespace WMC\StripeBundle\Form\Handler;

use Symfony\Component\Form\FormInterface,
    Symfony\Component\HttpFoundation\Request;

use Stripe\Customer;

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

    public function process($descriptionMetadata = null)
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData(), $descriptionMetadata);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(array $data, $descriptionMetadata = null)
    {
        if($descriptionMetadata){
            $descriptionMetadata = $this->form->get($descriptionMetadata)->getData();
        }

        $customer = Customer::create(
            array(
                "card" => $data['token'],
                "description" => '' . empty($descriptionMetadata) ? $this->description : $this->description . ' ('. $descriptionMetadata .')'
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
