<?php
namespace Kr\OAuthServerBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class OAuthFactory implements SecurityFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.access_token.'.$id;
        $container->setDefinition($providerId, new DefinitionDecorator('access_token.security.authentication.provider'));

        $listenerId = 'security.authentication.listener.access_token.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('access_token.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'oauth';
    }

    public function addConfiguration(NodeDefinition $node)
    {
    }
}