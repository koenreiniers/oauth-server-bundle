<?php
namespace Kr\OAuthServerBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractToken implements TokenInterface
{
    /** @var string */
    protected $token;

    /** @var \DateTime */
    protected $expiresAt;

    protected $client;

    /** @var UserInterface */
    protected $user;

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function isExpired()
    {
        if($this->expiresAt === null) {
            return false;
        }
        return $this->expiresAt < new \DateTime();
    }

    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}