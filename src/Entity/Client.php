<?php
namespace Kr\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Kr\OAuthServerBundle\Model\Client as BaseClient;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass
 */
class Client extends BaseClient
{
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $secret;

    /**
     * @ORM\Column(type="array")
     */
    protected $redirectUris = [];

    /**
     * @ORM\Column(type="array")
     */
    protected $allowedGrantTypes = [];

    /**
     * @ORM\OneToMany(targetEntity="AuthorizationCode", mappedBy="client")
     */
    protected $authorizationCodes;

    /**
     * @ORM\OneToMany(targetEntity="AccessToken", mappedBy="client")
     */
    protected $accessTokens;

    /** @var UserInterface */
    protected $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authorizationCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accessTokens = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
