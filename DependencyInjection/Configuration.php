<?php

namespace IMAG\PhdCallBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('imag_phd_call');
        $rootNode
            ->children()
                ->arrayNode('mailer')
                    ->children()
                        ->scalarNode('from')->defaultValue('phdCall@FQDN.com')->end()
                        ->scalarNode('to')->end()
                        ->scalarNode('subject')->end()
                        ->scalarNode('template')->end()
                    ->end()
                ->end()                    
                ->scalarNode('reviewer_pass')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ;
        
        return $treeBuilder;
    }
}
