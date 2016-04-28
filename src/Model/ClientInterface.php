<?php
namespace Kr\OAuthServerBundle\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Kr\OAuthServerBundle\Model\AccessTokenInterface;
use Kr\OAuthServerBundle\Model\AuthorizationCodeInterface;
use Symfony\Component\Security\Core\User\UserInterface;


interface ClientInterface
{

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getId();

    /**
     * Set secret
     *
     * @param string $secret
     *
     * @return $this
     */
    public function setSecret($secret);

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret();

    /**
     * Sets the name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();

    /**
     * Set redirectUris
     *
     * @param array $redirectUris
     *
     * @return $this
     */
    public function setRedirectUris(array $redirectUris);

    /**
     * Get redirectUris
     *
     * @return array
     */
    public function getRedirectUris();

    /**
     * @param string $redirectUri
     *
     * @return $this
     */
    public function addRedirectUri($redirectUri);

    /**
     * @param string $redirectUri
     *
     * @return $this
     */
    public function removeRedirectUri($redirectUri);

    /**
     * Set allowedGrantTypes
     *
     * @param array $allowedGrantTypes
     *
     * @return $this
     */
    public function setAllowedGrantTypes(array $allowedGrantTypes);

    /**
     * Get allowedGrantTypes
     *
     * @return array
     */
    public function getAllowedGrantTypes();

    /**
     * Allows a grant type
     *
     * @param string $grantType
     *
     * @return $this
     */
    public function allowGrantType($grantType);

    /**
     * Disallows a grant type
     *
     * @param string $grantType
     *
     * @return $this
     */
    public function disallowGrantType($grantType);

    /**
     * Returns whether or not a grant_type is allowed
     *
     * @param string $grantType
     *
     * @return bool
     */
    public function isAllowedGrantType($grantType);

    /**
     * @param AuthorizationCodeInterface $authorizationCodes
     * @return $this
     */
    public function addAuthorizationCode(AuthorizationCodeInterface $authorizationCodes);

    /**
     * @param AuthorizationCodeInterface $authorizationCodes
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCodes);

    /**
     * Get authorizationCodes
     *
     * @return Collection|AuthorizationCodeInterface[]
     */
    public function getAuthorizationCodes();

    /**
     * @param AccessTokenInterface $accessTokens
     *
     * @return $this
     */
    public function addAccessToken(AccessTokenInterface $accessTokens);

    /**
     * @param AccessTokenInterface $accessTokens
     */
    public function removeAccessToken(AccessTokenInterface $accessTokens);

    /**
     * Get accessTokens
     *
     * @return Collection|AccessTokenInterface[]
     */
    public function getAccessTokens();

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user);
}
