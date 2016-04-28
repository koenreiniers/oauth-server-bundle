<?php
namespace Kr\OAuthServerBundle\EventListener;

use Kr\OAuthServerBundle\Events\OAuthServerEvents;
use Kr\OAuthServerBundle\Events\GetResponseForAuthenticationEvent;
use Kr\OAuthServerBundle\Manager\AccessTokenManager;
use Kr\OAuthServerBundle\Manager\RefreshTokenManager;
use Kr\OAuthServerBundle\Model\ClientInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TokenResponseSubscriber implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    public static function getSubscribedEvents()
    {
        return [
            OAuthServerEvents::AUTHORIZATION_REQUEST   => ["onAuthorizationRequest", 50],
            OAuthServerEvents::TOKEN_REQUEST           => ["onTokenRequest", 50],
        ];
    }

    /** @var AccessTokenManager */
    protected $accessTokenManager;

    /** @var RefreshTokenManager */
    protected $refreshTokenManager;

    public function __construct(AccessTokenManager $accessTokenManager, RefreshTokenManager $refreshTokenManager)
    {
        $this->accessTokenManager = $accessTokenManager;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    protected function getResponseContent(ClientInterface $client, UserInterface $user)
    {
        // Add access_token
        $accessToken = $this->accessTokenManager->createAccessToken();
        $accessToken->setClient($client);
        $accessToken->setUser($user);
        $expiresIn = $accessToken->getExpiresAt()->getTimestamp() - time();
        $this->accessTokenManager->saveAccessToken($accessToken);
        $response = [
            "access_token"      => $accessToken->getToken(),
            "token_type"        => "bearer",
            "expires_in"        => $expiresIn,
        ];

        // Add refresh_token
        if(in_array("refresh_token", $client->getAllowedGrantTypes())) {
            $refreshToken = $this->refreshTokenManager->createRefreshToken();
            $refreshToken->setUser($user);
            $refreshToken->setClient($client);
            $response["refresh_token"] = $refreshToken->getToken();
            $this->refreshTokenManager->saveRefreshToken($refreshToken);
        }

        return $response;
    }

    /**
     * @param GetResponseForAuthenticationEvent $event
     */
    public function onTokenRequest(GetResponseForAuthenticationEvent $event)
    {
        if($event->getResponse() !== null) {
            return;
        }

        $client     = $event->getClient();
        $user       = $event->getUser();

        $content = $this->getResponseContent($client, $user);

        $response = new JsonResponse($content);
        $event->setResponse($response);
    }

    /**
     * @param GetResponseForAuthenticationEvent $event
     */
    public function onAuthorizationRequest(GetResponseForAuthenticationEvent $event)
    {
        if($event->getResponse() !== null) {
            return;
        }

        $request = $event->getRequest();

        // Only act on response_type=token
        $responseType   = $request->get("response_type");
        if($responseType !== "token") {
            return;
        }

        // Verify that implicit grants are allowed
        $client = $event->getClient();
        if(!$client->isAllowedGrantType("implicit")) {
            return;
        }

        $user = $event->getUser();

        $content = $this->getResponseContent($client, $user);
        $redirectUri    = $request->get("redirect_uri");
        $state          = $request->get("state");

        $queryData = [
            "state" => $state,
        ];

        $queryString = http_build_query($queryData);

        $url = $redirectUri . "?" . $queryString;

        $response = new RedirectResponse($url);
        $response->setContent(json_encode($content));

        $event->setResponse($response);
    }
}