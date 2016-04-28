<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Provider;

use Doctrine\ORM\EntityRepository;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RefreshTokenProvider implements AuthenticationProviderInterface
{
    use LoggerAwareTrait;

    /** @var EntityRepository */
    protected $refreshTokenRepository;

    /** @var EntityRepository */
    protected $clientRepository;

    public function __construct(EntityRepository $clientRepository, EntityRepository $refreshTokenRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
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
        $credentials    = $token->getCredentials();
        $clientId       = $credentials['client_id'];


        /** @var ClientInterface $client */
        $client = $this->clientRepository->find($clientId);

        // Verify client id
        if(!$client) {
            throw new AuthenticationException("Client with id $clientId does not exist");
        }

        // Verify client secret
        $clientSecret   = $credentials['client_secret'];
        if(!$client->getSecret() === $clientSecret) {
            throw new AuthenticationException("Invalid client secret");
        }

        // Verify grant type
        if(!in_array($token->getGrantType(), $client->getAllowedGrantTypes())) {
            throw new AuthenticationException("Grant type not allowed");
        }

        // Verify refresh_token
        $refreshToken = $this->refreshTokenRepository->findOneBy(["token" => $credentials['refresh_token'], "client" => $client]);
        if($refreshToken === null) {
            throw new AuthenticationException("Invalid token");
        }

        // Verify expiry date
        if($refreshToken->isExpired()) {
            throw new AuthenticationException("Token has expired");
        }


        $user = $refreshToken->getUser();

        $token->setUser($user);
        $token->setClient($client);

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof GrantToken && $token->getGrantType() === "refresh_token";
    }
}