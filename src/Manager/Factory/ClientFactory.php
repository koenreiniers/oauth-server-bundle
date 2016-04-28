<?php
namespace Kr\OAuthServerBundle\Manager\Factory;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Security\Utils\Random;

class ClientFactory implements FactoryInterface
{
    /** @var int */
    protected $secretLength;

    /** @var array  */
    protected $defaultGrantTypes;

    /** @var Random */
    protected $random;

    public function __construct(Random $random, array $defaultGrantTypes = [], $secretLength = 16)
    {
        $this->random       = $random;
        $this->defaultGrantTypes = $defaultGrantTypes;
        $this->secretLength = $secretLength;
    }

    protected function generateClientId()
    {
        $parts = [];
        for($i = 0; $i < 4; $i++) {
            $parts[] = $this->random->generateString(5);
        }

        $clientId = implode("-", $parts);
        return $clientId;
    }

    protected function generateClientSecret()
    {
        return $this->random->generateString($this->secretLength);
    }

    /**
     * @param string $className
     *
     * @return ClientInterface
     */
    public function create($className)
    {
        /** @var ClientInterface $client */
        $client = new $className();
        if(!$client instanceof ClientInterface) {
            throw new \RuntimeException("Class $className does not implement the correct interface");
        }

        $id     = $this->generateClientId();
        $secret = $this->generateClientSecret();


        $client->setId($id);
        $client->setSecret($secret);
        $client->setAllowedGrantTypes($this->defaultGrantTypes);

        return $client;
    }
}