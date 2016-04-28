<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\AccessTokenInterface;

interface AccessTokenManagerInterface extends ManagerInterface
{
    /**
     * Returns a new refresh token instance
     *
     * @return AccessTokenInterface
     */
    public function createAccessToken();

    /**
     * Saves the access token
     *
     * @param AccessTokenInterface $accessToken
     */
    public function saveAccessToken(AccessTokenInterface $accessToken);

    /**
     * Removes a single access token
     *
     * @param AccessTokenInterface $accessToken
     */
    public function removeAccessToken(AccessTokenInterface $accessToken);
}