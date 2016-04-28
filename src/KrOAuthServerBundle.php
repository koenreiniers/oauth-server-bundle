<?php
namespace Kr\OAuthServerBundle;

use Kr\OAuthServerBundle\DependencyInjection\KrOAuthServerExtension;
use Kr\OAuthServerBundle\DependencyInjection\Security\Factory\GrantRequestFactory;
use Kr\OAuthServerBundle\DependencyInjection\Security\Factory\OAuthFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KrOAuthServerBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new KrOAuthServerExtension();
    }
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new GrantRequestFactory());
        $extension->addSecurityListenerFactory(new OAuthFactory());
    }
}