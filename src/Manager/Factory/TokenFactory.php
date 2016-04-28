<?php
namespace Kr\OAuthServerBundle\Manager\Factory;

use Kr\OAuthServerBundle\Model\TokenInterface;
use Kr\OAuthServerBundle\Security\Utils\Random;

class TokenFactory implements FactoryInterface
{
    /** @var int */
    protected $lifetime;

    /** @var int */
    protected $length;

    /** @var Random */
    protected $random;

    public function __construct(Random $random, $lifetime = 3600, $length = 12)
    {
        $this->random = $random;
        $this->lifetime = $lifetime;
        $this->length   = $length;
    }

    /**
     * @param string $className
     *
     * @return TokenInterface
     */
    public function create($className)
    {
        /** @var TokenInterface $tokenInstance */
        $tokenInstance = new $className();
        if(!$tokenInstance instanceof TokenInterface) {
            throw new \RuntimeException("Class $className does not implement the correct interface");
        }

        // Set expiry time
        $expiresAt = null;
        if($this->lifetime !== null) {
            $expiresAt = (new \DateTime())->modify("+$this->lifetime seconds");
        }
        $tokenInstance->setExpiresAt($expiresAt);

        // Generate token string
        $token = $this->random->generateString($this->length);
        $tokenInstance->setToken($token);

        return $tokenInstance;
    }
}