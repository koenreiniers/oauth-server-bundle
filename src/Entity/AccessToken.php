<?php
namespace Kr\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kr\OAuthServerBundle\Model\AccessTokenInterface;
use Kr\OAuthServerBundle\Model\AccessToken as BaseAccessToken;

/**
 * @ORM\MappedSuperclass
 */
class AccessToken extends BaseAccessToken
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
    protected $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="accessTokens")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Pim\Bundle\UserBundle\Entity\User")
     */
    protected $user;

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
