<?php
namespace Kr\OAuthServerBundle\Model;

interface AuthorizationCodeInterface extends TokenInterface
{
    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * Set code
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code);

    /**
     * Returns the redirect uri
     *
     * @return string
     */
    public function getRedirectUri();

    /**
     * Sets the redirect uri
     *
     * @param string $redirectUri
     *
     * @return $this
     */
    public function setRedirectUri($redirectUri);
}