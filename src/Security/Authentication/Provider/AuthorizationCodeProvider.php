<?php
namespace Kr\OAuthServerBundle\Security\Authentication\Provider;

use Doctrine\ORM\EntityRepository;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Kr\OAuthServerBundle\Security\Authentication\Token\GrantToken;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\VarDumper\VarDumper;

class AuthorizationCodeProvider implements AuthenticationProviderInterface
{
    use LoggerAwareTrait;

    /** @var EntityRepository */
    protected $authorizationCodeRepository;

    /** @var EntityRepository */
    protected $clientRepository;

    public function __construct(EntityRepository $clientRepository, EntityRepository $authorizationCodeRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->authorizationCodeRepository = $authorizationCodeRepository;
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


        // Verify redirect uri
        $redirectUri    = $credentials['redirect_uri'];
        if(!in_array($redirectUri, $client->getRedirectUris())) {
            throw new AuthenticationException("Invalid redirect uri");
        }

        // Verify authorization code
        $code = $credentials['code'];
        $authorizationCode = $this->authorizationCodeRepository->findOneBy(["code" => $code, "client" => $client]);
        if($authorizationCode === null) {
            throw new AuthenticationException("Invalid code");
        }

        // Verify that redirect uri's match
        if($authorizationCode->getRedirectUri() !== $redirectUri) {
            throw new AuthenticationException("Redirect uri does not match redirect uri from previous request");
        }


        // Verify expiry date
        if($authorizationCode->isExpired()) {
            throw new AuthenticationException("Code has expired");
        }

        $user = $authorizationCode->getUser();

        $token->setUser($user);
        $token->setClient($client);

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof GrantToken && $token->getGrantType() === "authorization_code";
    }
}