StripeBundle
============

Provides a simple Symfony 2 Bundle to Wrap the Stripe PHP SDK 2 - https://github.com/stripe/stripe-php

## Installation

### composer.json

```json

    {
        "require": {
            "wemakecustom/stripe-bundle": "dev-master"
        }
    }

```

### app/AppKernel.php
```php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new WMC\StripeBundle\WMCStripeBundle(),
        );
    }

```

## Configuration

Edit your symfony config.yml file and add, at a minimum, the following lines:

    wmc_stripe:
        api_secret_key:      stripe_secret_key
        api_publishable_key: stripe_publishable_key

## Utilisation

### Authentification
In Stripe you have two form of authentication. The one by your server and the one by your client.

#### To authenticate your server with the stripe secret key

```php

    $this->container->get('wmc_stripe.stripe')->auth();
    // Instead of : Stripe::setApiKey("sk_somekey");

```

#### To authenticate your client with the stripe publishable key

Include all js at once in twig

```twig

    {% include "WMCStripeBundle::stripe.js.html.twig" %}

```

If you want to do it manually you have a twig extension to get the stripe_publishable_key

```twig

    <script type="text/javascript">Stripe.setPublishableKey('{{stripe_publishable_key}}');</script>

```

### Example

If you want to do a basic card submission
https://stripe.com/docs/tutorials/forms
https://stripe.com/docs/tutorials/charges#saving-credit-card-details-for-later

#### Basic saving of clients (card details), controller and a view :

```php

    public function newPaymentMethodAction(Request $request)
    {


        $this->container->get('wmc_stripe.stripe')->auth();

        $form = $this->createForm(new CardFormType());
        $formHandler = new CardFormHandler($form, $request, $stripeClientDescription);

        if($formHandler->process()){
            //Persist flush the customerId somewhere
            $stripeCustomerId = $formHandler->getCustomer()->id;
        }

        return array('form' => $form->createView());
    }
```

```twig

    {% extends "::base.html.twig" %}

    {% block content %}

        {{ form_start(form) }}
        {{ form_errors(form) }}
        {{ form_widget(form) }}

        <button type="submit">Submit</button>

        {{ form_end(form) }}

    {% endblock %}

    {% block foot_script %}
        {{ parent() }}
        {% include "WMCStripeBundle::stripe.js.html.twig" %}
    {% endblock %}
```

#### Charge a client


```php
            \Stripe_Charge::create(array(
                    "amount" => round($price * 100),
                    "currency" => "usd",
                    "customer" => $customerId)
            );
```