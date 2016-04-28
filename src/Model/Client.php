<?php
namespace Kr\OAuthServerBundle\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Kr\OAuthServerBundle\Model\AccessTokenInterface;
use Kr\OAuthServerBundle\Model\AuthorizationCodeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Client implements ClientInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $name;

    /** @var array */
    protected $redirectUris = [];

    /** @var array */
    protected $allowedGrantTypes = [];

    /** @var Collection|AuthorizationCodeInterface[] */
    protected $authorizationCodes;

    /** @var Collection|AccessTokenInterface[] */
    protected $accessTokens;

    /** @var UserInterface */
    protected $user;

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUris(array $redirectUris)
    {
        $this->redirectUris = $redirectUris;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUris()
    {
        return $this->redirectUris;
    }

    /**
     * @inheritdoc
     */
    public function addRedirectUri($redirectUri)
    {
        $this->redirectUris[] = $redirectUri;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeRedirectUri($redirectUri)
    {
        // TODO
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setAllowedGrantTypes(array $allowedGrantTypes)
    {
        $this->allowedGrantTypes = $allowedGrantTypes;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAllowedGrantTypes()
    {
        return $this->allowedGrantTypes;
    }

    /**
     * @inheritdoc
     */
    public function allowGrantType($grantType)
    {
        if(!in_array($grantType, $this->getAllowedGrantTypes())) {
            $this->allowedGrantTypes[] = $grantType;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function disallowGrantType($grantType)
    {
        $this->allowedGrantTypes = array_diff($this->getAllowedGrantTypes(), [$grantType]);
    }

    /**
     * @inheritdoc
     */
    public function isAllowedGrantType($grantType)
    {
        return in_array($grantType, $this->allowedGrantTypes);
    }

    /**
     * @inheritdoc
     */
    public function addAuthorizationCode(AuthorizationCodeInterface $authorizationCodes)
    {
        $this->authorizationCodes[] = $authorizationCodes;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeAuthorizationCode(AuthorizationCodeInterface $authorizationCodes)
    {
        $this->authorizationCodes->removeElement($authorizationCodes);
    }

    /**
     * @inheritdoc
     */
    public function getAuthorizationCodes()
    {
        return $this->authorizationCodes;
    }

    /**
     * @inheritdoc
     */
    public function addAccessToken(AccessTokenInterface $accessTokens)
    {
        $this->accessTokens[] = $accessTokens;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeAccessToken(AccessTokenInterface $accessTokens)
    {
        $this->accessTokens->removeElement($accessTokens);
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
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
