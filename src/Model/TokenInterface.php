<?php
namespace Kr\OAuthServerBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface TokenInterface
{
    public function getToken();

    public function setToken($token);

    public function isExpired();

    public function setExpiresAt(\DateTime $expiresAt);

    public function setClient($client);

    public function getClient();

    public function getUser();

    public function setUser(UserInterface $user);

    /**
     * Returns the datetime at which this token expires
     *
     * @return \DateTime
     */
    public function getExpiresAt();
}