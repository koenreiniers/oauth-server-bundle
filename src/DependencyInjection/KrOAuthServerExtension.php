<?php
namespace Kr\OAuthServerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class KrOAuthServerExtension extends Extension
{
    public function getAlias()
    {
        return "kr_oauth_server";
    }

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load("event_listeners.yml");
        $loader->load("managers.yml");
        $loader->load("repositories.yml");
        $loader->load("services.yml");
        $loader->load("factories.yml");
        $loader->load("grants.yml");

        $classmap = $config['classmap'];
        $this->configureClassmap($container, $classmap);
    }

    protected function configureClassmap(ContainerBuilder $container, $classmap)
    {
        $container->setParameter("kr.oauth_server.access_token.class", $classmap['access_token']);
        $container->setParameter("kr.oauth_server.refresh_token.class", $classmap['refresh_token']);
        $container->setParameter("kr.oauth_server.authorization_code.class", $classmap['authorization_code']);
        $container->setParameter("kr.oauth_server.client.class", $classmap['client']);
    }
}
