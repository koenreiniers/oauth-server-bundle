<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Token;

use Kr\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class GrantToken extends AbstractToken
{
    /** @var array */
    protected $credentials;

    /** @var string */
    protected $grantType;

    /** @var ClientInterface */
    protected $client;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;

        $roles = ["ROLE_OAUTH_GRANT", "ROLE_USER"];
        parent::__construct($roles);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @param string $grantType
     */
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
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




}