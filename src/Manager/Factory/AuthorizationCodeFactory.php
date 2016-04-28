<?php
namespace Kr\OAuthServerBundle\Manager\Factory;

use Kr\OAuthServerBundle\Model\AuthorizationCodeInterface;
use Kr\OAuthServerBundle\Security\Utils\Random;

class AuthorizationCodeFactory implements FactoryInterface
{
    /** @var int */
    protected $lifetime;

    /** @var int */
    protected $length;

    /** @var Random */
    protected $random;

    public function __construct(Random $random, $lifetime = 60, $length = 12)
    {
        $this->random = $random;
        $this->lifetime = $lifetime;
        $this->length   = $length;
    }

    /**
     * Returns a new authorization code instance
     *
     * @param string $className
     *
     * @return AuthorizationCodeInterface
     */
    public function create($className)
    {
        /** @var AuthorizationCodeInterface $authorizationCode */
        $authorizationCode = new $className();
        if(!$authorizationCode instanceof AuthorizationCodeInterface) {
            throw new \RuntimeException("Class $className does not implement the correct interface");
        }

        // Set expiry time
        $expiresAt = null;
        if($this->lifetime !== null) {
            $expiresAt = (new \DateTime())->modify("+$this->lifetime seconds");
        }
        $authorizationCode->setExpiresAt($expiresAt);

        // Generate token string
        $code = $this->random->generateString($this->length);
        $authorizationCode->setCode($code);

        return $authorizationCode;
    }
}