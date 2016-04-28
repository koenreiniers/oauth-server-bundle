<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Provider;

use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class GrantRequestProvider implements AuthenticationProviderInterface
{
    use LoggerAwareTrait;

    /** @var AuthenticationProviderInterface[] */
    protected $providers;

    public function __construct()
    {
        $this->providers = [];
    }

    public function addProvider(AuthenticationProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * @param TokenInterface $token
     *
     * @return AuthenticationProviderInterface|null
     */
    public function findProvider(TokenInterface $token)
    {
        foreach($this->providers as $provider) {
            if($provider->supports($token)) {
                return $provider;
            }
        }
        return null;
    }

    /**
     * Attempts to authenticate a GrantToken
     *
     * @param GrantToken $token
     *
     * @return GrantToken
     *
     * @throws AuthenticationException
     */
    public function authenticate(TokenInterface $token)
    {
        $provider = $this->findProvider($token);

        if($provider === null) {

            throw new AuthenticationException("Invalid grant type");
        }

        if($this->logger !== null) {
            $class = get_class($provider);
            $this->logger->debug("Provider matched: $class");
        }

        return $provider->authenticate($token);
    }

    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof GrantToken;
    }
}