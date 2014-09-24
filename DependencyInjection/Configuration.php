<?php

namespace WMC\StripeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wmc_stripe');

        $rootNode
            ->children()
                ->scalarNode('api_secret_key')
                    ->isRequired()
                    ->info('The secret key to connect to the Stripe API')
                ->end()
                ->scalarNode('api_publishable_key')
                    ->isRequired()
                    ->info('The publishable key to connect to the Stripe API')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
