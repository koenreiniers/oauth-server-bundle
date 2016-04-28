<?php
namespace Kr\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Kr\OAuthServerBundle\Model\AuthorizationCode as BaseAuthorizationCode;

/**
 * @ORM\MappedSuperclass
 */
class AuthorizationCode extends BaseAuthorizationCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="authorizationCodes")
     */
    protected $client;

    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $redirectUri;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
