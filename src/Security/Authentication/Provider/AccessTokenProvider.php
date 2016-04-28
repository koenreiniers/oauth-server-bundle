<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Provider;

use Doctrine\ORM\EntityRepository;
use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Kr\OAuthServerBundle\Security\Authentication\Token\OAuthToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccessTokenProvider implements AuthenticationProviderInterface
{
    use LoggerAwareTrait;

    /** @var EntityRepository */
    protected $accessTokenRepository;

    public function __construct(EntityRepository $accessTokenRepository)
    {
        $this->accessTokenRepository = $accessTokenRepository;
    }

    /**
     * Attempts to authenticate a GrantToken
     *
     * @param OAuthToken $token
     *
     * @return OAuthToken
     *
     * @throws AuthenticationException
     */
    public function authenticate(TokenInterface $token)
    {
        $tokenValue    = $token->getCredentials();

        $accessToken = $this->accessTokenRepository->findOneBy(["token" => $tokenValue]);

        if($accessToken === null) {
            throw new AuthenticationException("Invalid access token");
        }

        if($accessToken->isExpired()) {
            throw new AuthenticationException("Access token has expired");
        }


        $user = $accessToken->getUser();

        $token->setUser($user);

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof OAuthToken;
    }
}