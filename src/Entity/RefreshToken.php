<?php
namespace Kr\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kr\OAuthServerBundle\Model\RefreshToken as BaseRefreshToken;

/**
 * @ORM\MappedSuperclass
 */
class RefreshToken extends BaseRefreshToken
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
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="refreshTokens")
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
