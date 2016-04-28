<?php
namespace Kr\OAuthServerBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class GrantRequestFactory implements SecurityFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.grant_request.'.$id;
        $container->setDefinition($providerId, new DefinitionDecorator('grant_request.security.authentication.provider'));

        $listenerId = 'security.authentication.listener.grant_request.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('grant_request.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'grant_request';
    }

    public function addConfiguration(NodeDefinition $node)
    {
    }
}