<?php
namespace Kr\OAuthServerBundle\Manager;

use Kr\OAuthServerBundle\Model\AuthorizationCodeInterface;

interface AuthorizationCodeManagerInterface extends ManagerInterface
{
    /**
     * Returns a new authorization code instance
     *
     * @return AuthorizationCodeInterface
     */
    public function createAuthorizationCode();

    /**
     * Persists the authorization code
     *
     * @param AuthorizationCodeInterface $authorizationCode
     */
    public function saveAuthorizationCode(AuthorizationCodeInterface $authorizationCode);

    /**
     * Removes a single authorization code
     *
     * @param AuthorizationCodeInterface $authorizationCode
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCode);
}