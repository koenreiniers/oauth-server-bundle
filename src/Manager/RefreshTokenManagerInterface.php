<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\RefreshTokenInterface;

interface RefreshTokenManagerInterface extends ManagerInterface
{
    /**
     * Returns a new refresh token instance
     *
     * @return RefreshTokenInterface
     */
    public function createRefreshToken();

    /**
     * Persists the refresh token
     *
     * @param RefreshTokenInterface $refreshToken
     */
    public function saveRefreshToken(RefreshTokenInterface $refreshToken);

    /**
     * Removes a single refresh token
     *
     * @param RefreshTokenInterface $refreshToken
     */
    public function removeAuthorizationCode(RefreshTokenInterface $refreshToken);
}