<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Token;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class OAuthToken extends AbstractToken
{
    /** @var string */
    protected $token;

    /** @var ClientInterface */
    protected $client;

    public function getCredentials()
    {
        return $this->token;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


}