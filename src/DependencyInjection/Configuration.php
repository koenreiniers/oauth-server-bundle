<?php
namespace Kr\OAuthServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kr_oauth_server');

        $rootNode
            ->children()
                ->arrayNode("classmap")->children()
                    ->scalarNode("access_token")->isRequired()->end()
                    ->scalarNode("refresh_token")->isRequired()->end()
                    ->scalarNode("client")->isRequired()->end()
                    ->scalarNode("authorization_code")->isRequired()->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
