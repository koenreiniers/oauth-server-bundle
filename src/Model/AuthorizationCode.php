<?php
namespace Kr\OAuthServerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthorizationCode extends AbstractToken implements AuthorizationCodeInterface
{
    /** @var string */
    protected $code;

    /** @var \DateTime */
    protected $expiresAt;

    /** @var ClientInterface */
    protected $client;

    /** @var UserInterface */
    protected $user;

    /** @var string */
    protected $redirectUri;

    /**
     * @inheritdoc
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @inheritdoc
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }
}
